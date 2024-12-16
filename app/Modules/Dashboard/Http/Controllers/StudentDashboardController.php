<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\View\View;
use App\Modules\Quiz\Models\Quiz;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Course\Models\Course;
use App\Modules\Lesson\Models\Lesson;
use Illuminate\Support\Facades\Request;
use App\Modules\Assignment\Models\Assignment;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the courses along with sections, lessons, quizzes, and assignments
        $courses = auth()->user()->student->courses()->with([
            'sections.lessons', 
            'sections.quizzes', 
            'sections.assignments'
        ])->paginate(6);
        
        // tap($courses, function ($courses) {
        //     dd($courses); // This will pause here and show the result.
        // });
        

        // Add progress information for each course
        foreach ($courses as $course) {
            $course->progress = $course->getProgress();
        }

        // Return the data in JSON format if it's an AJAX request
        if (request()->ajax()) {
            return response()->json([
                'data' => $courses->items(),
                'pagination' => [
                    'total' => $courses->total(),
                    'current_page' => $courses->currentPage(),
                    'last_page' => $courses->lastPage(),
                ]
            ]);
        }

        return view('Dashboard::student.dashboard', compact('courses'));
    }
}


