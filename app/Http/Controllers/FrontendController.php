<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Instructor\Models\Instructor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{

    public function home()
    {
        try {
            // $data['instructors'] = Instructor::with('user')->get();
            // $data['courses'] = Course::where('status', 'active')
            //     ->orderBy('instructor_date', 'desc')
            //     ->paginate(6);
            // $data['committeeTypes'] = CommitteeType::all(); // Add this line

            $data['instructors'] = Instructor::where('status', 'active')->latest()->take(4)->get();
            return view('frontend.pages.home', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@home ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.index', ['error' => 'Unable to retrieve frontend data.']);
        }
    }

    public function instructorPage()
{
    try {
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
            $data['instructor'] = Instructor::findOrFail($id);
            return view('frontend.pages.instructor_details_page', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@instructor_details ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.pages.instructor_details_page', ['error' => 'Unable to retrieve instructor details.']);
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
