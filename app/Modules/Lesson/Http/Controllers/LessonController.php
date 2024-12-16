<?php

namespace App\Modules\Lesson\Http\Controllers;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Modules\Lesson\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use App\Modules\AboutUs\Models\AboutUs;
use App\Modules\Section\Models\Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Instructor\Models\Instructor;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Lesson\Http\Requests\StoreLessonRequest;

class LessonController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Lesson::with(['createdBy:id,name', 'updatedBy:id,name', 'section:id,title'])
                    ->select('id', 'title', 'course_section_id', 'status', 'created_by', 'updated_by')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('id', function ($list) {
                        return $list->id;
                    })
                    ->addColumn('title', function ($list) {
                        return $list->title;
                    })
                    ->addColumn('section_title', function ($list) {
                        return $list->section->title;
                    })
                    ->addColumn('status', function ($list) {
                        return $list->status;
                    })
                    ->addColumn('created_by', function ($list) {
                        return optional($list->createdBy)->name; // Show the name of the user who created the lesson
                    })
                    ->addColumn('updated_by', function ($list) {
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
        } catch (Exception $exception) {
            Log::error("Error occurred in LessonController@list({$exception->getFile()}:{$exception->getLine()}):{$exception->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Lesson-101]");
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['lesson_type_list'] = [
                '' => 'Select One',
                'youtube_video' => 'YouTube Video',
                'image' => 'Image',
                'video' => 'Video',
                'google_drive' => 'Google Drive',
                'text' => 'Text',
                'iframe' => 'iFrame',
                'document' => 'Document'
            ];
            $data['duration'] = 0;

            return view('Lesson::create', $data); // Pass data to the view
        } catch (Exception $e) {
            Log::error("Error occurred in LessonController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Lesson-102]");
            return redirect()->back();
        }
    }

    public function store(StoreLessonRequest $request)
    {
        try {
            if ($request->get('id')) {
                $lesson = Lesson::findOrFail($request->get('id'));
                $lesson->updated_by = auth()->id();
            } else {
                $lesson = new Lesson();
                $oldAttachment = null;
                $oldDocument = null;
                $oldGoogleDrive = null;
            }

            // Handle file uploads
            $image = $request->hasFile('image')
                ? $this->uploadFile($request->file('image'))
                : ($lesson->image ?? null);
            $iframe = $request->hasFile('iframe')
                ? $this->uploadFile($request->file('iframe'))
                : ($lesson->iframe ?? null);

            $attachmentData = [];
            if ($request->hasFile('attachment')) {
                $attachmentData[] = $this->uploadFile($request->file('attachment'));
            } elseif ($oldAttachment) {
                // Use the old attachment if no new file is uploaded
                $attachmentData[] = $oldAttachment[0];
            }
            $lesson->attachment = !empty($attachmentData) ? json_encode($attachmentData) : null;

            $documentData = [];
            if ($request->hasFile('document')) {
                $documentData[] = $this->uploadFile($request->file('document'));
            } elseif ($oldDocument) {
                // Use the old document if no new file is uploaded
                $documentData[] = $oldDocument[0];
            }
            $lesson->document = !empty($documentData) ? json_encode($documentData) : null;

            $googleDriveData = [];
            if ($request->hasFile('google_drive')) {
                $googleDriveData[] = $this->uploadFile($request->file('google_drive'));
            } elseif ($oldGoogleDrive) {
                // Use the old google_drive if no new file is uploaded
                $googleDriveData[] = $oldGoogleDrive[0];
            }
            $lesson->google_drive = !empty($googleDriveData) ? json_encode($googleDriveData) : null;

            $lesson->title = $request->get('title');
            $lesson->course_section_id = $request->get('section');
            $lesson->lesson_type = $request->get('lesson_type');
            $lesson->summary = $request->get('summary');
            $lesson->text = $request->get('text');
            $lesson->image = $image;
            $lesson->video = $request->get('video');
            $lesson->iframe = $iframe;

            $hours = (int) $request->get('hours', 0);
            $minutes = (int) $request->get('minutes', 0);
            $seconds = (int) $request->get('seconds', 0);
            $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            $durationFormatted = gmdate("H:i:s", $totalSeconds);
            $lesson->duration = $durationFormatted;

            $lesson->status = $request->get('status');
            $lesson->created_by = auth()->id();

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
            $durationParts = explode(':', $data['data']->duration);
            $totalSeconds = ($durationParts[0] * 3600) + ($durationParts[1] * 60) + ($durationParts[2]);
            $data['data']->total_seconds = $totalSeconds;

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
