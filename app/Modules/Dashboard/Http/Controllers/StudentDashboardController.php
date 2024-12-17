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
        $studentId = auth()->user()->id; // Assuming you get the student's ID this way
    
        // Fetch the courses, sections, lessons, quizzes, and assignments with raw query
        $enrolledCourses = DB::table('enroll_students')
            ->join('courses', 'enroll_students.course_id', '=', 'courses.id')
            ->join('course_sections', 'courses.id', '=', 'course_sections.course_id')
            ->leftJoin('course_lessons', 'course_sections.id', '=', 'course_lessons.course_section_id')
            ->leftJoin('course_quizzes', 'course_sections.id', '=', 'course_quizzes.course_section_id')
            ->leftJoin('course_assignments', 'course_sections.id', '=', 'course_assignments.course_section_id')
            ->where('enroll_students.student_id', $studentId)
            ->select(
                'courses.id as course_id',
                'courses.title as course_title',
                'course_sections.id as section_id',
                'course_sections.title as section_title',
                'course_lessons.id as lesson_id',
                'course_lessons.title as lesson_title',
                'course_quizzes.id as quiz_id',
                'course_quizzes.title as quiz_title',
                'course_assignments.id as assignment_id',
                'course_assignments.title as assignment_title'
            )
            ->get();
    
        // // Group the data by course_id and section_id
        // $groupedCourses = $enrolledCourses->groupBy('course_id')->map(function ($courseGroup) {
        //     return $courseGroup->groupBy('section_id')->map(function ($sectionGroup) {
        //         return [
        //             'section_title' => $sectionGroup->first()->section_title,
        //             'lessons' => $sectionGroup->pluck('lesson_title'),
        //             'quizzes' => $sectionGroup->pluck('quiz_title'),
        //             'assignments' => $sectionGroup->pluck('assignment_title'),
        //         ];
        //     });
        // });
    
        return view('Dashboard::student.dashboard', ['enrolledCourses' => $enrolledCourses]);
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
