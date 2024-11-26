<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

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
}
