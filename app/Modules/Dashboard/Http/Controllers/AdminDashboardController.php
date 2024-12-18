<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Modules\Course\Models\Course;
use App\Modules\Category\Models\Category;
use App\Modules\Lesson\Models\Lesson;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\Section\Models\Section;
use App\Modules\Quiz\Models\Quiz;
use App\Modules\Student\Models\Student;
use App\Modules\Instructor\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{

    public function __construct()
    {
        // You can also apply the 'admin' middleware here if needed
        $this->middleware('admin');
    }

    public function index()
    {
        // Fetching the total counts from respective models
        $totalCourses = Course::count();
        $totalCategories = Category::count();
        $totalAssignments = Assignment::count();
        $totalLessons = Lesson::count();
        $totalSections = Section::count();
        $totalQuizzes = Quiz::count();
        $totalStudents = Student::count();
        $totalInstructors = Instructor::count();

        // Passing the data to the view
        return view('Dashboard::admin.dashboard', compact(
            'totalCourses', 
            'totalCategories', 
            'totalAssignments', 
            'totalLessons', 
            'totalSections', 
            'totalQuizzes', 
            'totalStudents', 
            'totalInstructors'
        ));
    }

}
