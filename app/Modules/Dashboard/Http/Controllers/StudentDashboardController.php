<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Quiz\Models\Quiz;
use App\Modules\Course\Models\Course;
use App\Modules\Lesson\Models\Lesson;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Controllers\Controller;

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

        // Return the data in JSON format if it's an AJAX request
        if ($request->ajax()) {
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

    public function showCourse($courseId)
    {
        // Fetch course with its sections, lessons, quizzes, and assignments
        $course = Course::with(['sections.lessons', 'sections.quizzes', 'sections.assignments'])->findOrFail($courseId);
    
        return view('Dashboard::student.course.index', compact('course'));
    }

    public function showLesson($lessonId)
    {
        // Fetch lesson details
        $lesson = Lesson::findOrFail($lessonId);
        
        return view('Dashboard::student.lesson', compact('lesson'));
    }

    public function takeQuiz($quizId)
    {
        // Fetch quiz details
        $quiz = Quiz::findOrFail($quizId);
        
        return view('Dashboard::student.quiz', compact('quiz'));
    }

    public function viewAssignment($assignmentId)
    {
        // Fetch assignment details
        $assignment = Assignment::findOrFail($assignmentId);
        
        return view('Dashboard::student.assignment', compact('assignment'));
    }
}
