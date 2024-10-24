<?php

namespace App\Modules\Lesson\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Lesson\Http\Requests\StoreLessonRequest;
use App\Modules\Lesson\Models\Lesson;
use App\Modules\Instructor\Models\Instructor;
use App\Modules\Section\Models\Section;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;

class LessonController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request){
        try {
            if($request->ajax() && $request->isMethod('post')){
                $list = Lesson::with(['createdBy:id,name', 'updatedBy:id,name', 'section:id,title'])
                    ->select('id', 'title', 'section_id', 'status', 'created_by', 'updated_by')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('id', function ($list){
                        return $list->id;
                    })
                    ->addColumn('title', function($list){
                        return $list->title;
                    })
                    ->addColumn('section_title', function($list){
                        return $list->section->title;
                    })
                    ->addColumn('status', function($list){
                        return $list->status;
                    })
                    ->addColumn('created_by', function($list){
                        return optional($list->createdBy)->name; // Show the name of the user who created the lesson
                    })
                    ->addColumn('updated_by', function($list){
                        return optional($list->updatedBy)->name; // Show the name of the user who updated the lesson
                    })
                    ->addColumn('action', function ($list) {
                        return '<a href="' . URL::to('lesson/edit/' . $list->id) . '" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view("Lesson::list");
            }
        } catch(Exception $exception){
            Log::error("Error occurred in LessonController@list({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error',"Something went wrong during application data load [Lesson-101]");
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['lesson_type_list'] = ['' => 'Select One', 'youtube_video' => 'YouTube Video', 'image' => 'Image', 'video' => 'Video', 'google_drive' => 'Google Drive', 'text' => 'Text', 'iframe' => 'iFrame', 'document' => 'Document'];

            return view('Lesson::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in LessonController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Lesson-102]");
            return redirect()->back();
        }
    }

    public function store(StoreLessonRequest $request)
    {
        try {
            if ($request->get('id')){
                $lesson = Lesson::findOrFail($request->get('id'));
                $lesson->updated_by = auth()->id();
            } else {
                $lesson = new Lesson();
            }

            $lesson->title = $request->get('title');
            $lesson->course_section_id = $request->get('section');
            $lesson->lesson_type = $request->get('lesson_type');
            $lesson->summary = $request->get('summary');
            $lesson->text = $request->get('text');
            $lesson->iframe = $request->get('iframe');
            $lesson->status = $request->get('status');
            $lesson->created_by = auth()->id();

            // Handle file uploads
            if ($request->hasFile('video_file')) {
                $lesson->video_file = $request->file('video_file')->store('videos', 'public');
            }

            if ($request->hasFile('attachment')) {
                $lesson->attachment = $request->file('attachment')->store('attachments', 'public');
            }

            if ($request->hasFile('document')) {
                $lesson->document = $request->file('document')->store('documents', 'public');
            }

            // Additional fields based on lesson type
            if ($request->get('lesson_type') == 'youtube_video') {
                $lesson->video_url = $request->get('video_url');
                $lesson->duration = $request->get('hours') * 3600 + $request->get('minutes') * 60 + $request->get('seconds');
            }

            $lesson->save();
            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('lesson.list');
        } catch (Exception $e) {
            Log::error("Error occurred in LessonController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during the store process [Lesson-103]");
            return Redirect::back()->withInput();
        }
    }

    public function edit($id): View|RedirectResponse
    {
        try {
            $data['data'] = Lesson::findOrFail($id);
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['lesson_type_list'] = ['' => 'Select One', 'youtube_video' => 'YouTube Video', 'image' => 'Image', 'video' => 'Video', 'google_drive' => 'Google Drive', 'text' => 'Text', 'iframe' => 'iFrame', 'document' => 'Document'];

            return view('Lesson::edit', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in LessonController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Lesson-104]");
            return redirect()->back();
        }
    }
}
