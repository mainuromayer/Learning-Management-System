<?php

namespace App\Modules\Course\Http\Controllers;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\EnrollStudent\Models\EnrollStudent;
use App\Modules\Course\Http\Requests\StoreCourseRequest;

class CourseController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Course::with([
                    'category:id,category_name',
                    'instructor.user:id,name,email'
                ])
                    ->select('id', 'title', 'category_id', 'instructor_id', 'short_description', 'description', 'create_as', 'course_level', 'pricing_type', 'price', 'discount_price', 'thumbnail', 'status')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('title', function ($list) {
                        return $list->title;
                    })
                    ->addColumn('instructor_name', function ($list) {
                        return $list->instructor->user->name;
                    })
                    ->addColumn('instructor_email', function ($list) {
                        return $list->instructor->user->email;
                    })
                    ->addColumn('category', function ($list) {
                        return $list->category->category_name;
                    })
                    ->addColumn('enrolled_student', function ($list) {
                        return $list->enrollments()->count();
                    })
                    ->addColumn('status', function ($list) {
                        return $list->status;
                    })
                    ->addColumn('price', function ($list) {
                        return $list->price;
                    })
                    ->addColumn('action', function ($list) {
                        return '<a href="' . URL::to('course/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view("Course::list");
            }
        } catch (Exception $e) {
            Log::error("Error occurred in CourseController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Course-101]");
            return response()->json(['error' => "Something went wrong. Please try again."], Response::HTTP_INTERNAL_SERVER_ERROR);
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


    public function store(StoreCourseRequest $request) {
        try {
            Log::info('Incoming request data: ', $request->all());

            if ($request->get('id')) {
                $course = Course::findOrFail($request->get('id'));
                $course->updated_by = auth()->id();
            } else {
                $course = new Course();
            }

            // Handle file uploads
            $thumbnail = $request->hasFile('thumbnail')
                ? $this->uploadFile($request->file('thumbnail'))
                : ($course->thumbnail ?? null); // Keep the old thumbnail if no new one is uploaded

            // Fill the course model with validated data
            $course->title = $request->get('title');
            $course->short_description = $request->get('short_description', '');
            $course->description = $request->get('description', '');
            $course->create_as = $request->get('create_as');
            $course->category_id = $request->get('category');
            $course->instructor_id = $request->get('instructor');
            $course->course_level = $request->get('course_level');
            $course->pricing_type = $request->get('pricing_type');
            $course->price = $request->get('price');
            $course->discount_price = $request->get('discount_price', 0);
            $course->thumbnail = $thumbnail;
            $course->status = $request->get('status');
            $course->created_by = auth()->id();

            // Save the course
            $course->save();

            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('course.list');
        } catch (Exception $e) {
            Log::error("Error occurred in CourseController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Course-103]: " . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }


    public function edit( $id ): View | RedirectResponse {
        try {
            $data['category_list'] = ['' => 'Select One'] + Category::pluck('category_name', 'id')->toArray();
            $data['instructor_list'] = ['' => 'Select One'] + Instructor::all()->mapWithKeys(function ($instructor) {
                    return [$instructor->id => "{$instructor->user->name} - ({$instructor->user->email})"];
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