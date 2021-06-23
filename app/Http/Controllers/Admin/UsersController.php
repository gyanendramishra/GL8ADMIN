<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\UserRequest;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'filters' => Request::all('search', 'role', 'trashed'),
            'users' => Auth::user()
                ->orderByName()
                ->filter(Request::only('search', 'role', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'roles' => $user->roles->implode('name', ','),
                        'photo' => $user->photoUrl(['w' => 40, 'h' => 40, 'fit' => 'crop']),
                        'is_active' => $user->is_active,
                        'created_at' => $user->created_at->format('M/d/Y'),
                        'deleted_at' => $user->deleted_at,
                    ];
                }),
        ]);
    }

    /**
     * Show the resource create view.
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles'=> Role::isActive()
                ->get()
                ->transform(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name
                    ];
                })
        ]);
    }

    /**
     * Save the specified resource.
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        \DB::beginTransaction();
        try{
            $user = User::create([
                'first_name' => Request::get('first_name'),
                'last_name' => Request::get('last_name'),
                'email' => Request::get('email'),
                'phone' => Request::get('phone'),
                'photo_path' => Request::file('photo') ? Request::file('photo')->store('users', 'public') : null,
            ]);
            // Attach role with user
            $user->roles()->attach(Request::get('role'));
            $token = app('auth.password.broker')->createToken($user);
            try{
                //\Mail::to($user->email)->send(new ResetPasswordMail($user, $token));
            }catch(\Exception $e){
                \Log::info("User:: welcome email not sent");
            }
            // Db commit
            \DB::commit();
            return Redirect::route('admin.users.index')->with('success', 'User has been created successfully.');
        }catch(\Exception $e){
            \DB::rollBack();
            return Redirect::route('admin.users.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Show the resource edit view.
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->roles->first()->id,
                'photo' => $user->photoUrl(['w' => 60, 'h' => 60, 'fit' => 'crop']),
                'deleted_at' => $user->deleted_at,
            ],
            'roles'=> Role::isActive()
                ->get()
                ->transform(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name
                    ];
                })
        ]);
    }
    /**
     * Update the specified resource.
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        \DB::beginTransaction();
        try{
            $user->update(Request::only('first_name', 'last_name', 'email', 'phone'));
            if (Request::file('photo')) {
                $user->update(['photo_path' => Request::file('photo')->store('users')]);
            }
            // Sync role with user
            $user->roles()->sync($request->role);
            // Db commit
            \DB::commit();
            return Redirect::route('admin.users.index')->with('success', 'User has been updated updated successfully.');
        }catch(\Exception $e){
            \DB::rollBack();
            return Redirect::route('admin.users.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Destroy the specified resource.
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return Redirect::route('admin.users.index')->with('success', 'User has been deleted successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.users.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Restore the specified resource.
     * @param User $user
     * @return Response
     */
    public function restore(User $user)
    {
        try{
            $user->restore();
            return Redirect::route('admin.users.index')->with('success', 'User has been successfully restored.');
        }catch(\Exception $e){
            return Redirect::route('admin.users.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Toggle status of the specified resource.
     * @param User $user
     * @return Response
     */
    public function toggleStatus(User $user)
    {
        try{
            $user->is_active = $user->is_active ? User::IN_ACTIVE : User::ACTIVE;
            $user->save();
            return Redirect::route('admin.users.index')->with('success', 'User status has been successfully updated.');
        }catch(\Exception $e){
            return Redirect::route('admin.users.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
