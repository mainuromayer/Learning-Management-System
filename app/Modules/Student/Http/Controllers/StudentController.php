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

class StudentController extends Controller
{

    // public function welcome()
    // {
    //     return view("Student::welcome");
    // }

    public function list( Request $request )
    {
        try {
            if ( $request->ajax() && $request->isMethod( 'post' ) ) {
                $list = Student::select( 'id', 'name', 'phone')
                    ->orderBy( 'id' )
                    ->get();
                return Datatables::of($list)
                    ->editColumn( 'id', function ($list) {
                        return $list->id;
                    })
                    ->editColumn( 'name', function ($list) {
                        return $list->name;
                    })
                    ->editColumn( 'phone', function ($list) {
                        return $list->phone;
                    })
                    ->addColumn( 'action', function ( $list ) {
                        return '<a href="' . URL::to( 'student/edit/' . $list->id ) .
                            '" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a> ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else
            {
                return view("Student::list");
            }
        } catch ( Exception $e ) {
            Log::error( "Error occurred in StudentController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data load [Student-101]" );
            return response()->json( array( 'error' => $e->getMessage() ), Response::HTTP_INTERNAL_SERVER_ERROR );
        }

    }


    public function create(): View | RedirectResponse {
        // $data['zone_list'] = array('' => 'Select One' ) + Zone::pluck( 'zone_name', 'id' )->toArray();
        
        return view( 'Student::create');
    }

    public function store( StoreStudentRequest $request ) { 

        if ( $request->get( 'id' ) ) {
            $student = Student::findOrFail( $request->get( 'id' ) );
        } else {
            $student = new Student();
        }
        $student->name = $request->get('name');
        $student->biography = $request->get('biography');
        $student->phone = $request->get('phone'); 
        $student->address = $request->get('address'); 
        $student->image = $request->get('image'); 
        $student->email = $request->get('email'); 
        $student->password = $request->get('password'); 
        $student->facebook = $request->get('facebook'); 
        $student->twitter = $request->get('twitter'); 
        $student->linkedin = $request->get('linkedin');  
       
        $student->save();
        Session::flash( 'success', 'Data save successfully!' );
        return redirect()->route( 'student.list' );
    }

    public function edit( $id ): View | RedirectResponse {
        try {
            // $data['zone_list'] = array( '' => 'Select One' ) + Course::pluck( 'zone_name', 'id' )->toArray();

            $data['data'] = Student::findOrFail( $id );
            return view( 'Student::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in Student@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Student-103]" );
            return redirect()->back();
        }
    }

}
