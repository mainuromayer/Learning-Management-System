<?php

namespace App\Modules\Assignment\Http\Controllers;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Section\Models\Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Assignment\Models\Assignment;
use App\Modules\Instructor\Models\Instructor;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Assignment\Http\Requests\StoreAssignmentRequest;

class AssignmentController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Assignment::with([
                    'instructor.user:id,name,email',
                    'createdBy:id,name',
                    'updatedBy:id,name',
                    'section:id,title'
                ])
                    ->select('id', 'title', 'course_section_id', 'description','instructor_id', 'status', 'created_by', 'updated_by')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('title', function ($list) {
                        return $list->title;
                    })
                    ->addColumn('section_title', function($list){
                        return $list->section->title;
                    })
                    ->addColumn('instructor_name', function ($list) {
                        return $list->instructor->user->name ?? '';
                    })
                    ->addColumn('status', function ($list) {
                        return $list->status;
                    })
                    ->addColumn('created_by', function($list){
                        return optional($list->createdBy)->name;
                    })

                    ->addColumn('action', function ($list) {
                        return '<a href="' . URL::to('assignment/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view("Assignment::list");
            }
        } catch (Exception $e) {
            Log::error("Error occurred in AssignmentController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Assignment-101]");
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function create(): View | RedirectResponse {
        try {
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['instructor_list'] = ['' => 'Select One'] + Instructor::all()->mapWithKeys(function ($instructor) {
                    return [$instructor->id => "{$instructor->user->name} - ({$instructor->user->email})"];
                })->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            return view('Assignment::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in AssignmentController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Assignment-102]");
            return redirect()->back();
        }
    }


    public function store(StoreAssignmentRequest $request) {
        try {
            if ($request->get('id')) {
                $assignment = Assignment::findOrFail($request->get('id'));
                $assignment->updated_by = auth()->id();

                $oldAttachment = json_decode($assignment->attachment);
            } else {
                $assignment = new Assignment();
                $oldAttachment = null;
            }

            $attachmentData = [];
            if ($request->hasFile('attachment')) {
                $attachmentData[] = $this->uploadFile($request->file('attachment'));
            } elseif ($oldAttachment) {
                $attachmentData[] = $oldAttachment[0];
            }

            $assignment->attachment = !empty($attachmentData) ? json_encode($attachmentData) : null;

            $assignment->title = $request->get('title');
            $assignment->course_section_id = $request->get('section');
            $assignment->description = $request->get('description');
            $assignment->instructor_id = $request->get('instructor');
            $assignment->status = $request->get('status');
            $assignment->created_by = auth()->id();

            $assignment->save();

            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('assignment.list');
        } catch (Exception $e) {
            Log::error("Error occurred in AssignmentController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during the store process [Assignment-103]");
            return Redirect::back()->withInput();
        }
    }




    public function edit( $id ): View | RedirectResponse {
        try {
            $data['data'] = Assignment::findOrFail( $id );
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();

            $data['instructor_list'] = ['' => 'Select One'] + Instructor::all()->mapWithKeys(function ($instructor) {
                    return [$instructor->id => "{$instructor->user->name} - ({$instructor->user->email})"];
                })->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];

            return view( 'Assignment::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in AssignmentController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Assignment-104]" );
            return redirect()->back();
        }
    }

    public function removeImage(Request $request)
{
    try {
        $imagePath = $request->get('image');

        if (Storage::exists('public/' . $imagePath)) {
            Storage::delete('public/' . $imagePath);
            // Optionally remove the image path from the database if needed
            // $aboutUs = AboutUs::first();
            // $gallery = json_decode($aboutUs->gallery);
            // if (($key = array_search($imagePath, $gallery)) !== false) {
            //     unset($gallery[$key]);
            //     $aboutUs->gallery = json_encode($gallery);
            //     $aboutUs->save();
            // }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);

    } catch (Exception $e) {
        Log::error("Error removing image: {$e->getMessage()}");
        return response()->json(['success' => false, 'message' => 'Error removing image.']);
    }
}


}
