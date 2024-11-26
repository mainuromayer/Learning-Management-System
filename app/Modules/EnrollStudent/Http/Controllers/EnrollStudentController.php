<?php


namespace App\Modules\EnrollStudent\Http\Controllers;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use Illuminate\Http\RedirectResponse;
use App\Modules\Student\Models\Student;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\EnrollStudent\Models\EnrollStudent;

class EnrollStudentController extends Controller
{

    public function list(Request $request)
    {
        try {
            // If the request is AJAX, return the DataTables response
            if ($request->ajax() && $request->isMethod('post')) {
                $list = EnrollStudent::with(['student.user:id,name,email,image', 'courses:id,title'])
                    ->select('id', 'student_id', 'course_id', 'created_at') // Include student and course ids
                    ->orderBy('id')
                    ->get();
    
                return Datatables::of($list)
                    ->addColumn('name', function ($enrollment) {
                        return $enrollment->student->user->name;
                    })
                    ->addColumn('email', function ($enrollment) {
                        return $enrollment->student->user->email;
                    })
                    ->addColumn('image', function ($enrollment) {
                        return '<img src="' . ($enrollment->student->user->image ?? asset('images/default_avatar.png')) . '" alt="Profile Image" width="50" height="50">';
                    })
                    ->addColumn('course_title', function ($enrollment) {
                        return $enrollment->courses->title;
                    })
                    ->addColumn('enrollment_date', function ($enrollment) {
                        // Check if created_at is not null before formatting
                        return $enrollment->created_at ? $enrollment->created_at->format('Y-m-d') : 'N/A';
                    })
                    ->addColumn('action', function ($enrollment) {
                        return '<a href="' . route('enroll_student.edit', $enrollment->id) . '" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>';
                    })
                    ->rawColumns(['image', 'action']) // Allow raw HTML in image and action columns
                    ->make(true);
            }
    
            return view('EnrollStudent::list');
        } catch (Exception $e) {
            Log::error("Error in EnrollStudentController@list: {$e->getMessage()}");
            Session::flash('error', 'Error occurred while loading enrollments.');
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    
    
    
    

    public function create(): View | RedirectResponse
    {
        try {
            // Prepare student and course data for the dropdowns
            $data['student_list'] = ['' => 'Select One'] + Student::all()->mapWithKeys(function ($student) {
                return [$student->id => "{$student->user->name} - ({$student->user->email})"];
            })->toArray();

            $data['course_list'] = Course::all()->mapWithKeys(function ($course) {
                return [$course->id => $course->title];
            })->toArray();

            return view('EnrollStudent::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in EnrollStudentController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [EnrollStudent-102]");
            return redirect()->back();
        }
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     try {
    //         $validated = $request->validate([
    //             'student_id' => 'required|exists:students,id', // Ensure student_id is required and exists in the students table
    //             'course_id' => 'required|array',  // Ensure that course_id is an array (multiple selections)
    //             'course_id.*' => 'exists:courses,id', // Each selected course should exist in the courses table
    //         ]);
    
    //         // Find the student
    //         $student = Student::findOrFail($validated['student_id']);
    
    //         // Sync the courses (adding new and removing old ones)
    //         $student->enrollments()->sync($validated['course_id']);  // Sync ensures that we add/remove enrollments
    
    //         Session::flash('success', 'Student enrollment updated successfully!');
    //         return redirect()->route('enroll_student.list');
    //     } catch (Exception $e) {
    //         Log::error("Error occurred in EnrollStudentController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
    //         Session::flash('error', "Something went wrong during application data store [EnrollStudent-103]");
    //         return redirect()->back()->withInput();
    //     }
    // }
    


    // public function store(Request $request): RedirectResponse
    // {
        
    //     try {
    //         $validated = $request->validate([
    //             'student_id' => 'required|exists:students,id', // Correct 'student' to 'students'
    //             'course_id' => 'required|array',
    //             'course_id.*' => 'exists:courses,id',
    //         ]);
    
    //         // Create or update enrollment for the student and courses
    //         $student = Student::findOrFail($validated['student_id']);
    
    //         // Loop through the selected courses and store enrollment for each
    //         foreach ($validated['course_id'] as $course_id) {
    //             $enroll_student = new EnrollStudent();
    //             $enroll_student->student_id = $student->id;
    //             $enroll_student->course_id = $course_id;
    //             $enroll_student->save();
    //         }
            
    //         Session::flash('success', 'Student successfully enrolled in course(s)!');
    //         return redirect()->route('enroll_student.list');
    //     } catch (Exception $e) {
    //         Log::error("Error occurred in EnrollStudentController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
    //         Session::flash('error', "Something went wrong during application data store [EnrollStudent-103]");
    //         return redirect()->back()->withInput();
    //     }
    // }


    // In EnrollStudentController.php - store method
public function store(Request $request)
{
    DB::beginTransaction();
    
    try {
        // Log the request data before validation
        Log::info("Request Data: " . json_encode($request->all()));

        // Validate the request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id', // Ensure student_id is valid
            'course_id' => 'required|array',
            'course_id.*' => 'exists:courses,id', // Ensure all course_ids are valid
        ]);

        $student_id = $validated['student_id'];
        $course_ids = $validated['course_id'];
        
        // Log the data for debugging purposes
        Log::info("Student ID: {$student_id}, Course IDs: " . implode(',', $course_ids));
        
        // Check if the student ID is properly retrieved
        if (!$student_id) {
            throw new Exception("Student ID is null or invalid.");
        }

        // Find the student
        $student = Student::findOrFail($student_id);

        // Sync courses with the student (many-to-many relationship)
        $student->courses()->sync($course_ids);  // This is now valid because it's a BelongsToMany relationship
        
        // Commit transaction
        DB::commit();
        
        // Flash success message and redirect
        Session::flash('success', 'Student enrollment updated successfully!');
        return redirect()->route('enroll_student.list');
    } catch (Exception $e) {
        DB::rollBack();
        Log::error("Error occurred in EnrollStudentController@store: {$e->getMessage()}");
        Log::error("Request Data: " . json_encode($request->all()));
        Session::flash('error', "Something went wrong during the enrollment process.");
        return redirect()->back()->withInput();
    }
}

    
    
    
    
    
    
    
    
    
    public function edit($id): View | RedirectResponse
    {
        try {
            // Fetch the enrollment record along with its courses (many-to-many relationship)
            $enrollment = EnrollStudent::with('courses')->findOrFail($id);

            // Prepare student and course data for the dropdowns
            $data['student_list'] = ['' => 'Select One'] + Student::all()->mapWithKeys(function ($student) {
                return [$student->id => "{$student->user->name} - ({$student->user->email})"];
            })->toArray();

            $data['course_list'] = Course::all()->mapWithKeys(function ($course) {
                return [$course->id => $course->title];
            })->toArray();

            // Pass the enrollment data and course list to the view
            $data['enrollment'] = $enrollment;
            $data['selected_courses'] = $enrollment->courses->pluck('id')->toArray(); // All selected course IDs

            return view('EnrollStudent::edit', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in EnrollStudentController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during the edit process.");
            return redirect()->back();
        }
    }
    
    
    
    
    
}

