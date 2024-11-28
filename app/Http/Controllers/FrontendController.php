<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use App\Modules\AboutUs\Models\AboutUs;
use App\Modules\Instructor\Models\Instructor;

class FrontendController extends Controller
{

    public function home()
    {
        try {
            $data['instructors'] = Instructor::where('status', 'active')->latest()->take(4)->get();
            $data['courses'] = Course::where('status', 'active')->latest()->take(4)->get();
            $data['about_us'] = AboutUs::first();
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



    // public function frontend()
    // {
    //     try {
    //         $data['instructors'] = Instructor::with('user')->get();

    //         return view('frontend.index', $data);
    //     } catch (Exception $e) {
    //         Log::error("Error occurred in FrontendController@frontend ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
    //         return view('frontend.index', ['error' => 'Unable to retrieve frontend data.']);
    //     }
    // }
}
