<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Course\Models\Course;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StudentDashboardController extends Controller
{

    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        
        // Check if the user has an associated student
        $student = $user->student;
    
        // If no student record exists, handle the case
        if (!$student) {
            return redirect()->route('home')->with('error', 'Student record not found.');
        }
    
        // Otherwise, retrieve the student's courses
        $courses = $student->courses;
    
        // Fetching paginated courses here to send to the frontend
        $courses = $student->courses()->paginate(10);
    
        // Pass courses to the view
        return view('Dashboard::student.dashboard', compact('courses'));
    }
    






    public function getCourses(Request $request)
    {
        $user = Auth::user();

        // Ensure user is authenticated
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

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
