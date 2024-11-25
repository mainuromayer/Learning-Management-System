<?php

namespace App\Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Http\Requests\StoreCategoryRequest;
use App\Modules\Category\Models\Category;
use App\Modules\UserPermission\Models\Role;
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
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    use FileUploadTrait;

    public function list(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = Category::select('id', 'category_name', 'keywords', 'description', 'thumbnail')
                    ->orderBy('id')
                    ->paginate(9); // Limit to 9 categories per page

                return response()->json([
                    'data' => $list->items(),
                    'pagination' => [
                        'total' => $list->total(),
                        'current_page' => $list->currentPage(),
                        'last_page' => $list->lastPage(),
                        'per_page' => $list->perPage(),
                    ]
                ]);
            } else {
                return view("Category::list");
            }
        } catch (Exception $e) {
            Log::error("Error in CategoryController@list ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during data load [Category-101]");
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function create(): View|RedirectResponse
    {
        try {
            $data['boxicons'] = [
                'bx-user', 'bx-home', 'bx-cog', 'bx-heart', 'bx-bell', 'bx-search', 'bx-star', 'bx-trash', 'bx-pencil', 
                'bx-camera', 'bx-calendar', 'bx-message', 'bx-cart', 'bx-lock', 'bx-cloud', 'bx-wallet'
            ];
            return view('Category::create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in CategoryController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data create [Category-102]");
            return redirect()->back();
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            if ($request->has('id')) {
                // Find the existing category by ID
                $category = Category::findOrFail($request->get('id'));
            } else {
                // Create a new category
                $category = new Category();
            }
    
            // Handle file uploads, if any
            $thumbnail = $request->hasFile('thumbnail') ? $this->uploadFile($request->file('thumbnail')) : $category->thumbnail;
            $category_logo = $request->hasFile('category_logo') ? $this->uploadFile($request->file('category_logo')) : $category->category_logo;
    
            // Update category data
            $category->category_name = $request->input('category_name');
            $category->icon = $request->input('icon');
            
            // Convert keywords to JSON format
            $category->keywords = json_encode($request->input('keywords', []));
            
            $category->description = $request->input('description', '');
            $category->thumbnail = $thumbnail;
            $category->category_logo = $category_logo;
    
            // Save the category
            $category->save();
    
            // Set success message and redirect
            Session::flash('success', 'Data saved successfully!');
            return redirect()->route('category.list');
        } catch (Exception $e) {
            // Log the error and set error message
            Log::error("Error occurred in CategoryController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [Category-103]");
            return Redirect::back()->withInput();
        }
    }
    

    public function edit($id): View|RedirectResponse
    {
        try {
            $data['data'] = Category::findOrFail($id);

            $data['boxicons'] = [
                'bx-user', 'bx-home', 'bx-cog', 'bx-heart', 'bx-bell', 'bx-search', 'bx-star', 'bx-trash', 'bx-pencil', 
                'bx-camera', 'bx-calendar', 'bx-message', 'bx-cart', 'bx-lock', 'bx-cloud', 'bx-wallet'
            ];

            // Retrieve all keywords and flatten the array
            $allKeywords = Category::pluck('keywords')->map(function($keywords) {
                return json_decode($keywords, true);
            })->flatten()->unique();

            // Convert keywords to a list of key-value pairs for the select input
            $keywordsList = $allKeywords->mapWithKeys(function($keyword) {
                return [$keyword => ucfirst($keyword)];
            })->toArray();

            $data['keywordsList'] = $keywordsList;

            return view('Category::edit', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in CategoryController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [Category-104]");
            return redirect()->back();
        }
    }


}
