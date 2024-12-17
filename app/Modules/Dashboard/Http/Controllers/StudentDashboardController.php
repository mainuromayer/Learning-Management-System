<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Quiz\Models\Quiz;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use App\Modules\Lesson\Models\Lesson;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\EnrollStudent\Models\EnrollStudent;
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




    // Show course details
    public function showCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('Dashboard::student.course', compact('course'));
    }

    // Show lesson details
    public function showLesson($lessonId)
    {
        // Assuming a lesson model with details
        $lesson = Lesson::findOrFail($lessonId);
        return view('Dashboard::student.lesson', compact('lesson'));
    }

    // Show quiz details
    public function takeQuiz($quizId)
    {
        // Assuming a quiz model with details
        $quiz = Quiz::findOrFail($quizId);
        return view('Dashboard::student.quiz', compact('quiz'));
    }

    // Show assignment details
    public function viewAssignment($assignmentId)
    {
        // Assuming an assignment model with details
        $assignment = Assignment::findOrFail($assignmentId);
        return view('Dashboard::student.assignment', compact('assignment'));
    }
}
