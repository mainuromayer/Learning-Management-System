<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Course\Models\Course;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\Instructor\Models\Instructor;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        // Get the instructor associated with the authenticated user
        $instructor = Instructor::where('user_id', $user->id)->first();
    
        // Check if the instructor exists
        if (!$instructor) {
            return redirect()->route('login')->with('error', 'Instructor not found.');
        }
    
        // Fetch the courses associated with the instructor
        $courses = $instructor->courses;
    
        // Check if the instructor has any courses
        if ($courses->isEmpty()) {
            return view('Dashboard::instructor.dashboard')->with('error', 'No courses found for this instructor.');
        }
    
        return view('Dashboard::instructor.dashboard', compact('courses'));
    }

    // public function showCourse($courseId)
    // {
    //     $course = Course::with([
    //         'sections.lessons', 
    //         'sections.quizzes',
    //     ])->get();
    //     dd($course);
    //     $user = Auth::user();
    //     $instructor = Instructor::where('user_id', $user->id)->first();
    //     $assignment = Assignment::where('instructor_id',  $instructor->id)->get();
    //     dd($assignment);


    //     // Get the course with sections, lessons, quizzes, and assignments
    //     // $course = Course::with([
    //     //     'sections.lessons', 
    //     //     'sections.quizzes',
    //     // ])->where('id', $courseId)
    //     //   ->where('instructor_id', Auth::id()) // Ensure the course belongs to the instructor
    //     //   ->firstOrFail();
            
    //     // Fetch assignments for the instructor
    //     // $assignments = Assignment::where('instructor_id', Auth::id())
    //     //                          ->whereIn('course_section_id', $course->sections->pluck('id'))
    //     //                          ->get();
                                 

    //     return view('Dashboard::instructor.course.index', compact('course', 'assignments'));
    // }


    public function showCourse($courseId)
    {
        // Retrieve the course with related sections, lessons, and quizzes
        $course = Course::with([
            'sections.lessons', 
            'sections.quizzes',
        ])->where('id', $courseId)
          ->firstOrFail(); // Ensures course exists

        // Get the authenticated instructor
        $user = Auth::user();
        $instructor = Instructor::where('user_id', $user->id)->first();
        
        // Fetch assignments related to the instructor
        $assignments = Assignment::where('instructor_id', $instructor->id)
                                 ->whereIn('course_section_id', $course->sections->pluck('id')) // Match assignments with course sections
                                 ->get();

        // Debugging output (optional, for debugging purposes)
        // dd($course, $assignments);


        // Return the view with the course and assignments
        return view('Dashboard::instructor.course.index', compact('course', 'assignments'));
    }

}




