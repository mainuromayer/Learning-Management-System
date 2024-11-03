<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Instructor\Models\Instructor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function frontend()
    {
        try {
            $data['instructors'] = Instructor::with('user')->get();

            return view('frontend.index', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@frontend ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.index', ['error' => 'Unable to retrieve frontend data.']);
        }
    }


    public function about()
    {
        try {
            return view('frontend.pages.about');
        } catch (Exception $e) {
            Log::error("Error occurred in FrontendController@frontend ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return view('frontend.about', ['error' => 'Unable to retrieve frontend data.']);
        }
    }
}
