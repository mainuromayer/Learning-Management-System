<?php

namespace App\Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Student\Http\Requests\StoreStudentRequest;
use App\Modules\Student\Models\Student;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Modules\Course\Models\Course;
use App\Modules\User\Models\User;
use App\Modules\UserPermission\Models\Role;
use App\Traits\FileUploadTrait;


class StudentController extends Controller
{

    use FileUploadTrait;


    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Student::join('users', 'students.user_id', '=', 'users.id')
                    ->select('students.id', 'users.name', 'users.email', 'students.phone')
                    ->groupBy('students.id', 'users.name', 'users.email', 'students.phone')
                    ->orderBy('students.id')
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
                    ->addColumn('action', function ($item) {
                        return '<a href="' . route('student.edit', $item->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('Student::list');
            }
        } catch (Exception $e) {
            Log::error("Error occurred in StudentController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Student-101]");
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function create(): View|RedirectResponse
    {
        try {
            return view('Student::create');
        } catch (Exception $e) {
            Log::error("Error occurred in StudentController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Student-102]");
            return redirect()->back();
        }
    }


    public function store(StoreStudentRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->has('id')) {
                    $student = Student::findOrFail($request->get('id'));
                } else {
                    $student = new Student();
                }

                if (!$student->user_id) {
                    $user = new User();
                    $user->name = $request->get('name');
                    $user->password = Hash::make($request->get('password'));
                    $user->user_type = 'student';
                    $role = Role::where('slug', 'student')->first(); // use first() to get a single role
                    $user->role_id = $role->id ?? '';
                    $user->email = $request->get('email');
                    $user->save();

                    $student->user_id = $user->id;
                }

                // Handle file uploads
                $user_image = $request->hasFile('user_image') ? $this->uploadFile($request->file('user_image')) : $student->user_image;

                $student->biography = $request->get('biography');
                $student->phone = $request->get('phone');
                $student->address = $request->get('address');
                $student->user_image = $user_image;
                $student->facebook = $request->get('facebook');
                $student->twitter = $request->get('twitter');
                $student->linkedin = $request->get('linkedin');
                $student->save();
            });

            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('student.list');
        } catch (Exception $e) {
            Log::error("Error occurred in StudentController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Student-103]");
            return Redirect::back()->withInput();
        }
    }



    public function edit($id): View|RedirectResponse
    {
        try {
            $data['data'] = Student::findOrFail($id);
            return view('Student::edit', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in StudentController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Student-104]");
            return redirect()->back();
        }
    }

}
