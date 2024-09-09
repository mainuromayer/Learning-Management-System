<?php

namespace App\Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use App\Traits\FileUploadTrait;
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
class CourseController extends Controller
{
    use FileUploadTrait;

    public function list( Request $request )
    {
        try {
            if ( $request->ajax() && $request->isMethod( 'post' ) ) {
                $list = Course::with( ['categories:id,category_name', 'instructors:id,name,email'] )->select( 'id', 'title', 'short_description', 'description','create_as', 'category','course_level','pricing_type','price','discounted_price','thumbnail')
                    ->orderBy( 'id' )
                    ->get();
                return Datatables::of($list)
                    ->editColumn( 'title', function ($list) {
                        return $list->title;
                    })
                    ->editColumn( 'categories', function ( $list ) {
                        return $list->categories->category_name ?? '';
                    } )
                    ->editColumn( 'instructors', function ( $list ) {
                        return $list->instructors->name ?? '';
                    } )
                    ->editColumn( 'instructors', function ( $list ) {
                        return $list->instructors->email ?? '';
                    } )
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
                        return '<a href="' . URL::to('user/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a> ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else
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
        try {
            $data['category_list'] = ['' => 'Select One'] + Category::pluck('category_name', 'id')->toArray();
            $data['instructor_list'] = ['' => 'Select One'] + Instructor::all()->mapWithKeys(function ($instructor) {
                    return [$instructor->id => "{$instructor->user->name} - ({$instructor->user->email})"];
                })->toArray();
            $data['course_level_list'] = ['' => 'Select One', 'Beginner' => 'Beginner', 'Intermediate' => 'Intermediate',  'Advanced' => 'Advanced'];
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            return view('Course::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in CourseController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Course-102]");
            return redirect()->back();
        }
    }


    public function store( StoreCourseRequest $request ) {
        try {
            if ( $request->get( 'id' ) ) {
                $course = Course::findOrFail( $request->get( 'id' ) );
            } else {
                $course = new Course();
            }
            // Handle file uploads
            $thumbnail = $request->hasFile('thumbnail') ? $this->uploadFile($request->file('thumbnail')) : '';

            $course->title = $request->get('title');
            $course->short_description = $request->get('short_description');
            $course->description = $request->get('description');
            $course->create_as = $request->get('create_as');
            $course->category_id = $request->get('categories');
            $course->instructor_id = $request->get('instructors');
            $course->course_level = $request->get('course_level');
            $course->pricing_type = $request->get('pricing_type');
            $course->price = $request->get('price');
            $course->discounted_price = $request->get('discounted_price');
            $course->thumbnail = $thumbnail;
            $course->status = $request->get('status');

            $course->save();
            Session::flash( 'success', 'Data save successfully!' );
            return redirect()->route( 'course.list' );
        } catch (Exception $e) {
            // Log the error and set error message
            Log::error("Error occurred in CourseController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Course-103]");
            return Redirect::back()->withInput();
        }
    }

    public function edit( $id ): View | RedirectResponse {
        try {
            $data['category_list'] = ['' => 'Select One'] + Category::pluck('category_name', 'id')->toArray();
            $data['instructors_list'] = ['' => 'Select One'] + Instructor::all()->mapWithKeys(function ($instructor) {
                    return [$instructor->id => "{$instructor->name} ({$instructor->email})"];
                })->toArray();
            $data['course_level_list'] = ['' => 'Select One', 'Beginner' => 'Beginner', 'Intermediate' => 'Intermediate',  'Advanced' => 'Advanced'];
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            $data['data'] = Course::findOrFail( $id );
            return view( 'Course::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in CourseController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Course-104]" );
            return redirect()->back();
        }
    }

}
