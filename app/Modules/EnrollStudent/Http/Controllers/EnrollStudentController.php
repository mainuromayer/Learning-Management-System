<?php


namespace App\Modules\EnrollStudent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use App\Modules\Student\Models\Student;
use App\Modules\Course\Models\Course;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;

class EnrollStudentController extends Controller
{
    /**
     * List the enrollments (students and courses).
     */
    public function list(Request $request)
    {
        try {
            // If the request is AJAX, return the DataTables response
            if ($request->ajax() && $request->isMethod('post')) {
                $list = EnrollStudent::with(['student.user:id,name,email,image', 'course:id,title'])
                    ->select('id', 'student_id', 'course_id', 'created_at') // Include created_at as enrollment_date
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
                        return $enrollment->course->title;
                    })
                    ->addColumn('enrollment_date', function ($enrollment) {
                        return $enrollment->created_at->format('Y-m-d');
                    })
                    ->addColumn('action', function ($enrollment) {
                        return '<a href="' . route('enroll_student.edit', $enrollment->id) . '" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>';
                    })
                    ->rawColumns(['image', 'action']) // Allow raw HTML in image and action
                    ->make(true);
            }
    
            // If not AJAX, render the view for the enrollment list
            return view('EnrollStudent::list');
        } catch (Exception $e) {
            Log::error("Error in EnrollStudentController@list: {$e->getMessage()}");
            Session::flash('error', 'Error occurred while loading enrollments.');
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    /**
     * Show the form to create a new enrollment.
     */
    public function create(): View | RedirectResponse
    {
        try {
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

    /**
     * Store the new enrollment data.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id', // Correct 'student' to 'students'
                'course_id' => 'required|array',
                'course_id.*' => 'exists:courses,id',
            ]);
    
            // Create or update enrollment for the student and courses
            $student = Student::findOrFail($validated['student_id']);
    
            // Loop through the selected courses and store enrollment for each
            foreach ($validated['course_id'] as $course_id) {
                $enroll_student = new EnrollStudent();
                $enroll_student->student_id = $student->id;
                $enroll_student->course_id = $course_id;
                $enroll_student->save();
            }
    
            // Success message
            Session::flash('success', 'Student successfully enrolled in courses!');
            return redirect()->route('enroll_student.list');
        } catch (Exception $e) {
            Log::error("Error occurred in EnrollStudentController@store: {$e->getMessage()}");
            Session::flash('error', "Something went wrong during the store process [EnrollStudent-103]");
            return redirect()->back()->withInput();
        }
    }
    
    
    
    
    

    /**
     * Show the form to edit an existing enrollment.
     */
    public function edit($id): View | RedirectResponse
    {
        try {
            // Fetch the enrollment record along with its courses
            $enrollment = EnrollStudent::with('course')->findOrFail($id);
    
            // Fetch students and courses, mapping them like in the create method
            $data['student_list'] = ['' => 'Select One'] + Student::all()->mapWithKeys(function ($student) {
                return [$student->id => "{$student->user->name} - ({$student->user->email})"];
            })->toArray();
    
            $data['course_list'] = Course::all()->mapWithKeys(function ($course) {
                return [$course->id => $course->title];
            })->toArray();
    
            // Pass the enrollment and course list to the view
            $data['enrollment'] = $enrollment;
    
            return view('EnrollStudent::edit', $data);
        } catch (Exception $e) {
            // Log error and redirect with an error message
            Log::error("Error occurred in EnrollStudentController@edit: {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [EnrollStudent-104]");
            return redirect()->back();
        }
    }
    
    
}

