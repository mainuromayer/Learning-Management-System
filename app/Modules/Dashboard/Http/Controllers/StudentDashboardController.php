<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Course\Models\Course;
use Illuminate\Support\Facades\Request;

class StudentDashboardController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
      $student = auth()->user();
      $courses = $student->courses;
      
      if (!$courses) {
        $courses = [];
      }
      return view('Dashboard::student.dashboard', compact('courses'));
    }


    public function getCourses(Request $request)
    {
        $user = Auth::user();

        // Fetch courses for the student with instructor's user name
        $courses = Course::with('instructor.user') // Eager load the instructor's user relationship
            ->whereHas('students', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })
            ->paginate(10);

        return response()->json([
            'data' => $courses->items(),
            'pagination' => [
                'total' => $courses->total(),
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
            ]
        ]);
    }
    

}
