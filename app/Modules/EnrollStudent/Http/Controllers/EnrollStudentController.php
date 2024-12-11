<?php

namespace App\Modules\EnrollStudent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use App\Modules\Student\Models\Student;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;

class EnrollStudentController extends Controller {


    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = EnrollStudent::with(['student.user:id,name,email', 'courses:id,title'])
                    ->select('id', 'student_id', 'course_id', 'created_at')
                    ->orderBy('id')
                    ->get();
    
                return Datatables::of($list)
                    ->addColumn('id', function ($enrollment) {
                        return $enrollment->id;
                    })
                    ->addColumn('name', function ($enrollment) {
                        return $enrollment->student->user->name;
                    })
                    ->addColumn('email', function ($enrollment) {
                        return $enrollment->student->user->email;
                    })
                    ->addColumn('course_title', function ($enrollment) {
                        return $enrollment->courses ? $enrollment->courses->title : 'No Course Assigned';
                    })
                    ->addColumn('created_at', function ($enrollment) {
                        return $enrollment->created_at;
                    })
                    ->addColumn('action', function ($enrollment) {
                        return '<a href="' . route('enroll_student.edit', $enrollment->id) . '" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
    
            return view('EnrollStudent::list');
        } catch (Exception $e) {
            Log::error("Error in EnrollStudentController@list: {$e->getMessage()}");
            Session::flash('error', 'Error occurred while loading enrollments.');
            return response()->json(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    




    public function create(): View | RedirectResponse {
        try {
            // Prepare student and course data for the dropdowns
            $data['student_list'] = ['' => 'Select One'] + Student::all()->mapWithKeys( function ( $student ) {
                return [$student->id => "{$student->user->name} - ({$student->user->email})"];
            } )->toArray();

            $data['course_list'] = Course::all()->mapWithKeys( function ( $course ) {
                return [$course->id => $course->title];
            } )->toArray();

            return view( 'EnrollStudent::create', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in EnrollStudentController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data create [EnrollStudent-102]" );
            return redirect()->back();
        }
    }

public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Log the request data before validation
        Log::info("Request Data: " . json_encode($request->all()));

        // Validate the request
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id', // Ensure student_id is valid
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

        // Get the current timestamp for the pivot table
        $currentTimestamp = now();

        // Sync courses with the student and update pivot timestamps
        $student->courses()->sync(
            $course_ids,
            false // The 'false' argument here prevents detaching existing records
        );

        // Update timestamps manually if necessary
        foreach ($course_ids as $course_id) {
            $student->courses()->updateExistingPivot($course_id, [
                'updated_at' => $currentTimestamp,
                'created_at' => $currentTimestamp, // Only if you want to reset the created_at field
            ]);
        }

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

    

    public function edit( $id ): View | RedirectResponse {
        try {
            // Fetch the enrollment record along with its courses (many-to-many relationship)
            $enrollment = EnrollStudent::with( 'courses' )->findOrFail( $id );

            // Prepare student and course data for the dropdowns
            $data['student_list'] = ['' => 'Select One'] + Student::all()->mapWithKeys( function ( $student ) {
                return [$student->id => "{$student->user->name} - ({$student->user->email})"];
            } )->toArray();

            $data['course_list'] = Course::all()->mapWithKeys( function ( $course ) {
                return [$course->id => $course->title];
            } )->toArray();

            // Pass the enrollment data and course list to the view
            $data['enrollment'] = $enrollment;
            $data['selected_courses'] = $enrollment->courses->pluck( 'id' )->toArray(); // All selected course IDs

            return view( 'EnrollStudent::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in EnrollStudentController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during the edit process." );
            return redirect()->back();
        }
    }

}