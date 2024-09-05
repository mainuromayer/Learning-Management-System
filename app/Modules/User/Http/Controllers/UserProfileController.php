<?php

namespace App\Modules\User\Http\Controllers;
use App\Libraries\ImageProcessing;
use App\Modules\Employee\Models\Employee;
use App\Modules\User\Http\Requests\StoreUserProfileRequest;
use App\Modules\User\Models\User;
use App\Modules\UserPermission\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class UserProfileController {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */

    public function profile(Request $request)
    {
        $data = ['data' => Auth::user()];
        $data['roles'] = ['' => 'Select One'] + Role::pluck( 'title', 'id' )->toArray();
        return view( 'User::profile', $data);
    }

    public function update (StoreUserProfileRequest $request){
        try {
            $user = User::findOrFail( $request->get( 'id' ));
            // user profile picture
            if (!empty($request->user_pic_base64)) {
                $yearMonth = "uploads/".date("Y") . "/" . date("m") . "/";
                $path_with_dir = config('app.upload_doc_path') . $yearMonth;
                if (!file_exists($path_with_dir)) {
                    mkdir($path_with_dir, 0777, true);
                }
                $splited = explode(',', substr($request->get('user_pic_base64'), 5), 2);
                $imageData = $splited[1];
                $base64ResizeImage = base64_encode(ImageProcessing::resizeBase64Image($imageData, 300, 300));
                $base64ResizeImage = base64_decode($base64ResizeImage);
                $user_picture_name = time(). '.' . 'jpeg';
                file_put_contents($path_with_dir . $user_picture_name, $base64ResizeImage);

                $user->image = $path_with_dir . $user_picture_name;
            }

            $user->name = $request->get( 'name' );
            $user->email = $request->get( 'email' );
            $user->user_type = '1';
            $user->save();
            Session::flash( 'success', 'Data save successfully!' );
            return Redirect::back()->withInput();
        } catch ( Exception $e ) {
            Log::error( "Error occurred in UserProfileController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data store [UPC-103]" );
            return Redirect::back()->withInput();
        }
    }

}
