<?php

namespace App\Modules\Section\Http\Controllers;

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
use App\Modules\Section\Models\Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Section\Http\Requests\StoreSectionRequest;

class SectionController extends Controller
{
    use FileUploadTrait;
    public function list(Request $request){
        try {
            if($request->ajax() && $request->isMethod('post')){
                // Load 'user' relationship for 'created_by' and 'updated_by' fields
                $list = Section::with(['createdBy:id,name', 'updatedBy:id,name'])
                    ->select('id', 'title', 'status', 'created_by', 'updated_by')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('id', function ($list){
                        return $list->id;
                    })
                    ->addColumn('title', function($list){
                        return $list->title;
                    })
                    ->addColumn('status', function($list){
                        return $list->status;
                    })
                    ->addColumn('created_by', function($list){
                        return optional($list->createdBy)->name; // Show the name of the user who created the section
                    })
                    ->addColumn('updated_by', function($list){
                        return optional($list->updatedBy)->name; // Show the name of the user who updated the section
                    })
                    ->addColumn('action', function ($list) {
                        return '<a href="' . URL::to('section/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view("Section::list");
            }
        } catch(Exception $exception){
            Log::error("Error occurred in SectionController@list({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error',"Something went wrong during application data load [Section-101]");
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function create(): View | RedirectResponse {
        try {
            $data['course_list'] = ['' => 'Select One'] + Course::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            return view('Section::create',$data);
        } catch(Exception $exception){
            Log::error("Error occurred in SectionController@create({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Section-102]");
            return redirect()->back();
        }
    }

    public function store(StoreSectionRequest $request){
        try {
            if ($request->get('id')){
                $section = Section::findOrFail($request->get('id'));
                $section->updated_by = auth()->id();
            } else {
                $section = new Section();
            }
            $section->title = $request->get('title');
            $section->status = $request->get('status');
            $section->created_by = auth()->id();

            $section->save();
            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('section.list');
        } catch (Exception $exception){
            Log::error( "Error occurred in SectionController@store({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error', 'Something went wrong during the store process [Section-103]');
            return Redirect::back()->withInput();
        }
    }


    public function edit($id): View | RedirectResponse {
        try {
            $data = Section::findOrFail($id);
            $data['course_list'] = ['' => 'Select One'] + Course::pluck('title', 'id')->toArray();
            $status_list = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            return view("Section::edit", compact('data', 'status_list')); // Pass the data and status list to view
        } catch (Exception $exception) {
            Log::error("Error occurred in SectionController@edit({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error', 'Something went wrong during application data edit [Section-104]');
            return redirect()->back();
        }
    }


}
