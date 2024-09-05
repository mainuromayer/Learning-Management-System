<?php

namespace App\Modules\User\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Modules\User\Http\Requests\StoreAuthPasswordRequest;
use Illuminate\View\View;


class AuthPasswordController {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password():View
    {
        $data['data'] = Auth::user();
        return view( 'User::reset_password', $data);
    }

    public function update_password(StoreAuthPasswordRequest $request)
    {
        try {
            $user = Auth::user();
            if (Hash::check($request->get('old_password'), $user->password))
            {
                $user->password = Hash::make($request->get('new_password'));
                $user->save();
            } else
            {
                Session::flash( 'error', "Password Not Matched [UPC-103]" );
                return Redirect::back()->withInput();
            }
            Session::flash( 'success', 'Password reset successful!' );
            return Redirect::back()->withInput();
        } catch ( Exception $e ) {
            Log::error( "Error occurred in AuthPasswordController@update_password ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}" );
            Session::flash( 'error', "Something went wrong during application data store [APC-103]" );
            return Redirect::back()->withInput();
        }
    }



}
