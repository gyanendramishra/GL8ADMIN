<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\ProfileRequest;
use Inertia\Inertia;
use App\Models\User;

class ProfileController extends Controller
{
    
    /**
     * Display the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return Inertia::render('Profile/Index', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->roles->first()->name,
                'photo' => $user->photoUrl(['w' => 60, 'h' => 60, 'fit' => 'crop']),
                'deleted_at' => $user->deleted_at,
            ]
        ]);
    }
    /**
     * Update the specified resource.
     * @param User $user
     * @return Response
     */
    public function update(ProfileRequest $request)
    {
        $user = Auth::guard('admin')->user();
        try{
            $user->update(Request::only('first_name', 'last_name', 'email', 'phone'));
            if (Request::file('photo')) {
                $user->update(['photo_path' => Request::file('photo')->store('users')]);
            }
            return Redirect::back()->with('success', 'Profile has been updated successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.profile')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
