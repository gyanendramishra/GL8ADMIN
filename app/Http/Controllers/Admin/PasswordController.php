<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Mails\Admin\PasswordChanged;
use Inertia\Inertia;

class PasswordController extends Controller
{
    
    /**
     * Display the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Profile/Password');
    }
    /**
     * Update the specified resource.
     * @param PasswordRequest $request
     * @return Response
     */
    public function update(PasswordRequest $request)
    {
        $user = Auth::guard('admin')->user();
        try{
            $user->update(['password' => Request::get('new_password')]);
            Auth::logoutOtherDevices(Request::get('new_password'));
            // Send mail to user
            try{
                Mail::to($user)->send(new PasswordChanged($user));
            }catch(\Exception $e){
                \Log::info("User:: password changed email not sent");
            }
            return Redirect::back()->with('success', 'Password has been updated successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.password')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
