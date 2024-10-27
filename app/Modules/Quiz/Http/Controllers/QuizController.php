<?php

namespace App\Modules\Quiz\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Models\Category;
use App\Modules\Instructor\Models\Instructor;
use App\Modules\Section\Models\Section;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Modules\Quiz\Http\Requests\StoreQuizRequest;
use App\Modules\Quiz\Models\Quiz;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use yajra\Datatables\Datatables;
class QuizController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Quiz::with(['createdBy:id,name', 'updatedBy:id,name', 'section:id,title'])
                    ->select('id', 'title', 'course_section_id', 'status', 'created_by', 'updated_by')
                    ->orderBy('id')
                    ->get();

                return Datatables::of($list)
                    ->addColumn('id', function ($list) {
                        return $list->id;
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
                return view("Quiz::list");
            }
        } catch (Exception $e) {
            Log::error("Error occurred in QuizController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Quiz-101]");
            return response()->json(['error' => "Something went wrong. Please try again."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function create(): View | RedirectResponse {
        try {
            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['duration'] = 0;

            return view('Quiz::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in QuizController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Quiz-102]");
            return redirect()->back();
        }
    }


    public function store(StoreQuizRequest $request) {
        try {
            Log::info('Incoming request data: ', $request->all());

            if ($request->get('id')) {
                $quiz = Quiz::findOrFail($request->get('id'));
                $quiz->updated_by = auth()->id();
            } else {
                $quiz = new Quiz();
            }

            $quiz->title = $request->get('title');
            $quiz->course_section_id = $request->get('section');

            $hours = (int) $request->get('hours', 0);
            $minutes = (int) $request->get('minutes', 0);
            $seconds = (int) $request->get('seconds', 0);
            $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            $durationFormatted = gmdate("H:i:s", $totalSeconds);
            $quiz->duration = $durationFormatted;

            $quiz->total_mark = $request->get('total_mark');
            $quiz->pass_mark = $request->get('pass_mark');
            $quiz->retake = $request->get('retake');
            $quiz->description = $request->get('description');
            $quiz->status = $request->get('status');
            $quiz->created_by = auth()->id();

            // Save the quiz
            $quiz->save();

            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('quiz.list');
        } catch (Exception $e) {
            Log::error("Error occurred in QuizController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Quiz-103]: " . $e->getMessage());
            return Redirect::back()->withInput();
        }
    }


    public function edit( $id ): View | RedirectResponse {
        try {
            $data['data'] = Quiz::findOrFail( $id );

            $data['section_list'] = ['' => 'Select One'] + Section::pluck('title', 'id')->toArray();
            $data['status_list'] = ['' => 'Select One', 'active' => 'active', 'inactive' => 'inactive'];
            $data['duration'] = 0;

            return view( 'Quiz::edit', $data );
        } catch ( Exception $e ) {
            Log::error( "Error occurred in QuizController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data edit [Quiz-104]" );
            return redirect()->back();
        }
    }

}
