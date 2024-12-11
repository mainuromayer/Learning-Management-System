<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use App\Modules\Course\Models\Course;
use App\Modules\AboutUs\Models\AboutUs;
use App\Modules\Student\Models\Student;
use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use App\Modules\EnrollStudent\Models\EnrollStudent;

class FrontendController extends Controller
{

    public function home()
    {
        try {
            $data['instructors'] = Instructor::where('status', 'active')->latest()->take(4)->get();
            $data['courses'] = Course::where('status', 'active')->latest()->take(4)->get();
            $data['about_us'] = AboutUs::first();
            $data['categories'] = Category::withCount('courses')->latest()->take(4)->get();
            return view('frontend.pages.home', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@home ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.index', ['error' => 'Unable to retrieve frontend data.']);
        }
    }

    public function instructorPage()
    {
        try {
            $data['about_us'] = AboutUs::first();
            $data['instructors'] = Instructor::where('status', 'active')->latest()->paginate(6);
            return view('frontend.pages.instructor_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@instructorPage ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.instructor_page', ['error' => 'Unable to retrieve instructor data.']);
        }
    }



    public function instructorDetails($id)
    {
        try {
            $data['about_us'] = AboutUs::first();
            $data['instructor'] = Instructor::findOrFail($id);
            return view('frontend.pages.instructor_details_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@instructor_details ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.instructor_details_page', ['error' => 'Unable to retrieve instructor details.']);
        }
    }


    public function coursesPage()
    {
        try {
            $data['about_us'] = AboutUs::first();
            $data['courses'] = Course::where('status', 'active')->latest()->paginate(6); // Adjust to fetch only active courses
            return view('frontend.pages.course_page', $data); // Pass courses to the view
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@coursesPage ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.course_page', ['error' => 'Unable to retrieve courses.']);
        }
    }

    public function courseDetails($id)
    {
        try {
            $data['about_us'] = AboutUs::first();
            $data['course'] = Course::findOrFail($id);
            return view('frontend.pages.course_details_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@course_details ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.course_details_page', ['error' => 'Unable to retrieve course details.']);
        }
    }

    public function enrollCourse($id)
    {
        try {
            // Step 1: Check if the user is authenticated
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'You must be logged in to enroll.');
            }
        
            // Step 2: Get the logged-in user
            $user = auth()->user();
        
            // Step 3: Ensure the user is a student
            if ($user->user_type != 'student') {
                return redirect()->route('home')->with('error', 'You must be a student to enroll.');
            }
        
            // Step 4: Get the student ID from the authenticated user
            $student_id = $user->id; // Using the user ID directly here
        
            // Step 5: Ensure the student exists
            $student = Student::where('user_id', $student_id)->first();
            if (!$student) {
                return redirect()->route('home')->with('error', 'Student record not found.');
            }

            // Step 6: Fetch the course by its ID
            $course = Course::findOrFail($id); 
        
            // Step 7: Check if the student is already enrolled in the course
            $enrollment = EnrollStudent::where('student_id', $student->id)
                                       ->where('course_id', $course->id)
                                       ->first();
        
            if ($enrollment) {
                
                return redirect()->route('student.dashboard')->with('error', 'You are already enrolled in this course.');
            }
        
            // Step 8: Enroll the student in the course by inserting into the enroll_students table
            EnrollStudent::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            // Step 9: Flash success message and redirect
            return redirect()->route('student.dashboard')->with('success', 'You have successfully enrolled in the course!');
        
        } catch (Exception $e) {
            // Step 10: Error handling
            Log::error("Error occurred in FrontendController@enrollCourse ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
    
            return redirect()->route('home')->with('error', 'An error occurred while processing your enrollment.');
        }
    }
    
    
    
    
    
    
    
    


    public function aboutUs()
    {
        try {
            $data['about_us'] = AboutUs::first();
            return view('frontend.pages.about_us', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@about_us ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.about_us', ['error' => 'Unable to retrieve about us data.']);
        }
    }

    public function categoryPage()
    {
        try {
            $data['about_us'] = AboutUs::first();
            // Get categories with course count
            $data['categories'] = Category::withCount('courses')->latest()->paginate(4);  // Using courses relationship to count the courses

            return view('frontend.pages.category_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@categoryPage ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.category_page', ['error' => 'Unable to retrieve categories data.']);
        }
    }

    public function categoryDetails($id)
    {
        try {
            $data['category'] = Category::with('courses')->findOrFail($id);
            $data['about_us'] = AboutUs::first();

            return view('frontend.pages.category_details_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@categoryDetails ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.category_details_page', ['error' => 'Unable to retrieve category details.']);
        }
    }



    public function contact()
    {
        try {
            $data['about_us'] = AboutUs::first();

            return view('frontend.pages.contact_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@contact ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.contact', ['error' => 'Unable to retrieve contact page data.']);
        }
    }

    public function submitContactForm(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            // Optionally, save the contact message to the database (optional)
            ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);

            // Send the contact form data via email to the email provided in the form
            Mail::to($validated['email'])->send(new ContactFormMail($validated));

            return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@submitContactForm ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return redirect()->route('contact')->with('error', 'An error occurred while sending your message.');
        }
    }


}
