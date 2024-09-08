<?php

namespace App\Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Modules\Course\Http\Requests\StoreCourseRequest;
use App\Modules\Course\Models\Course;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;
use App\Modules\Zone\Http\Controllers\Gate;
class CourseController extends Controller
{

    public function list( Request $request )
    {
        try {
            if ( $request->ajax() && $request->isMethod( 'post' ) ) {
                $list = Course::select( 'id', 'title', 'short_description', 'description','create_as', 'category','course_level','pricing_type','price','discounted_price','thumbnail')
                    ->orderBy( 'id' )
                    ->get();
                return Datatables::of($list)
                    ->editColumn( 'title', function ($list) {
                        return $list->title;
                    })
                    ->editColumn( 'short_description', function ($list) {
                        return $list->short_description;
                    })
                    ->editColumn( 'description', function ( $list ) {
                        return $list->description;
                    })
                    ->editColumn( 'create_as', function ( $list ) {
                        return $list->create_as;
                    })
                    ->editColumn( 'category', function ( $list ) {
                        return $list->category;
                    })
                    ->editColumn( 'course level', function ( $list ) {
                        return $list->course_level;
                    })
                    ->editColumn( 'pricing_type', function ( $list ) {
                        return $list->pricing_type;
                    })
                    ->editColumn( 'price', function ( $list ) {
                        return $list->price;
                    }) 
                    ->editColumn( 'discounted price', function ( $list ) {
                        return $list->discounted_price;
                    })
                    ->editColumn('thumbnail', function ( $list ) {
                        return $list->thumbnail;
                    })
                    ->addColumn( 'action', function ( $list ) {
                        return '<a href="' . URL::to( 'course/edit/' . $list->id ) .
                            '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a> ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else
            {
                return view("Course::list");
            }
        } catch ( Exception $e ) {
            Log::error( "Error occurred in CourseController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data load [Course-101]" );
            return response()->json( array( 'error' => $e->getMessage() ), Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }
    public function create(): View | RedirectResponse {
        // $data['zone_list'] = array('' => 'Select One' ) + Zone::pluck( 'zone_name', 'id' )->toArray();
        
        return view( 'Course::create');
    }
    public function store( StoreCourseRequest $request ) { 

        if ( $request->get( 'id' ) ) {
            $course = Course::findOrFail( $request->get( 'id' ) );
        } else {
            $course = new Course();
        }
        $course->title = $request->get('title');
        $course->short_description = $request->get('short_description');
        $course->description = $request->get('description'); 
        $course->create_as = $request->get('create_as'); 
        $course->category = $request->get('category'); 
        $course->course_level = $request->get('course_level'); 
        $course->pricing_type = $request->get('pricing_type'); 
        $course->price = $request->get('price'); 
        $course->discounted_price = $request->get('discounted_price'); 
        $course->thumbnail = $request->get('thumbnail');  
       
        $course->save();
        Session::flash( 'success', 'Data save successfully!' );
        return redirect()->route( 'course.list' );
    }
    public function edit( $id ): View | RedirectResponse {
        try {
            // $data['zone_list'] = array( '' => 'Select One' ) + Course::pluck( 'zone_name', 'id' )->toArray();

            $data['data'] = Course::findOrFail( $id );
            return view( 'Course::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in Course@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Course-103]" );
            return redirect()->back();
        }
    }

}
