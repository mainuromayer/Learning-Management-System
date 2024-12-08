<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Modules\Course\Models\Course;
use App\Modules\AboutUs\Models\AboutUs;
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
            // Fetch the course by its ID
            $course = Course::findOrFail($id);

            // Check if the user is logged in
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'You must be logged in to enroll.');
            }

            // Check if the user is already enrolled in the course
            $user = auth()->user();
            $enrollment = EnrollStudent::where('user_id', $user->id)->where('course_id', $course->id)->first();

            if ($enrollment) {
                return redirect()->route('course_details', $course->id)->with('message', 'You are already enrolled in this course.');
            }

            // Create an enrollment record
            EnrollStudent::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'status' => 'enrolled',
            ]);

            return redirect()->route('course_details', $course->id)->with('success', 'You have successfully enrolled in the course!');
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@enrollCourse ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return redirect()->route('course_details', $id)->with('error', 'An error occurred while processing your enrollment.');
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
