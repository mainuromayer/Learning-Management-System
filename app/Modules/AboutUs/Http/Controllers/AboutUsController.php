<?php

namespace App\Modules\AboutUs\Http\Controllers;

use Exception;
use App\Modules\AboutUs\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Modules\AboutUs\Http\Requests\StoreAboutUsRequest;


class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = AboutUs::first();  

            if (!$data) {
                $data = new AboutUs();
            }
    
            return view('AboutUs::index', compact('data'));
    
        } catch (Exception $e) {
            Log::error("Error occurred in AboutUsController@index: {$e->getMessage()}");
            Session::flash('error', "Error loading About Us form.");
            return redirect()->back();
        }
    }
    
    

    
    
// Store method in AboutUsController
public function store(StoreAboutUsRequest $request)
{
    try {
        $about_us = $request->get('id') ? AboutUs::findOrFail($request->get('id')) : new AboutUs();
        $about_us->title = $request->get('title');
        $about_us->description = $request->get('description');
        $about_us->address = $request->get('address');
        $about_us->phone = $request->get('phone');
        $about_us->email = $request->get('email');
        $about_us->facebook = $request->get('facebook');
        $about_us->twitter = $request->get('twitter');
        $about_us->youtube = $request->get('youtube');
        $about_us->linkedin = $request->get('linkedin');

        $points = $request->get('points', []);
        $about_us->points = json_encode($points);

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('about-us/gallery', 'public');
            }
            $about_us->gallery = json_encode($galleryPaths);
        }

        if ($request->hasFile('image')) {
            $about_us->image = $request->file('image')->store('about-us/images', 'public');
        }

        $about_us->save();

        Session::flash('success', 'Data saved successfully!');

        return redirect()->route('about_us.index', ['id' => $about_us->id])
                         ->with('data', $about_us);

    } catch (Exception $e) {
        Log::error("Error occurred in AboutUsController@store: {$e->getMessage()}");
        Session::flash('error', "Error saving About Us data.");
        return Redirect::back()->withInput();
    }
}


    
    
}
