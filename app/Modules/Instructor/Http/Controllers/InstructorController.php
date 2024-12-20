<?php

namespace App\Modules\Instructor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use App\Modules\Instructor\Http\Requests\StoreInstructorRequest;
use App\Modules\Instructor\Models\Instructor;
use App\Modules\User\Models\User;
use App\Modules\UserPermission\Models\Role;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class InstructorController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Instructor::join('users', 'instructors.user_id', '=', 'users.id')
                ->leftJoin('courses', 'instructors.id', '=', 'courses.instructor_id')
                ->where('instructors.status', 'active') // Only active instructors
                ->select('instructors.id', 'users.name', 'users.email', 'instructors.phone')
                ->selectRaw('COUNT(courses.id) as course_count')
                ->groupBy('instructors.id', 'users.name', 'users.email', 'instructors.phone')
                ->orderBy('instructors.id')
                ->get();

                return Datatables::of($list)
                    ->editColumn('name', function ($item) {
                        return $item->name;
                    })
                    ->editColumn('email', function ($item) {
                        return $item->email;
                    })
                    ->editColumn('phone', function ($item) {
                        return $item->phone;
                    })
                    ->addColumn('course_count', function ($item) {
                        return $item->course_count ?? 0;
                    })
                    ->addColumn('action', function ($item) {
                        return '<a href="' . route('instructor.edit', $item->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('Instructor::list');
            }
        } catch (Exception $e) {
            Log::error("Error occurred in InstructorController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Instructor-101]");
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['course_list'] = ['' => 'Select One'] + Course::all()->mapWithKeys(function ($course) {
                return [$course->id => "{$course->course_id} - ({$course->title})"];
            })->toArray();
            return view('Instructor::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in InstructorController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Instructor-102]");
            return redirect()->back();
        }
    }

    public function store(StoreInstructorRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->has('id')) {
                    $instructor = Instructor::findOrFail($request->get('id'));
                    $user = $instructor->user;  // Fetch the associated user
                } else {
                    $instructor = new Instructor();
                    $user = new User();
                    $user->user_type = 'instructor';
                    $role = Role::where('slug', 'instructor')->first(); // use first() to get a single role
                    $user->role_id = $role->id ?? '';
                }

                // Update or create user
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->get('password'));  // Update password if provided
                }
                $user->save();  // Save user

                // Associate user with instructor
                $instructor->user_id = $user->id;
                $instructor->biography = $request->get('biography');
                $instructor->phone = $request->get('phone');
                $instructor->address = $request->get('address');
                $instructor->facebook = $request->get('facebook');
                $instructor->twitter = $request->get('twitter');
                $instructor->linkedin = $request->get('linkedin');
                $instructor->status = $request->get('status');

                // Handle file upload for instructor image (if any)
                if ($request->hasFile('user_image')) {
                    $instructor->user_image = $this->uploadFile($request->file('user_image'));
                }

                $instructor->save();  // Save instructor record
            });

            Session::flash('success', 'Instructor data saved successfully!');
            return redirect()->route('instructor.list');
        } catch (Exception $e) {
            Log::error("Error occurred in InstructorController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Instructor-103]");
            return Redirect::back()->withInput();
        }
    }


    public function edit($id): View|RedirectResponse
    {
        try {
            $data['data'] = Instructor::findOrFail($id);
            $data['course_list'] = ['' => 'Select One'] + Course::all()->mapWithKeys(function ($course) {
                    return [$course->id => "{$course->course_id} - ({$course->title})"];
                })->toArray();
                $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            return view('Instructor::edit', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in InstructorController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Instructor-104]");
            return redirect()->back();
        }
    }
}

