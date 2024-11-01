<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all active users
        $users = User::with('role')->where('is_active', '1')->sortable()->paginate(10);
        return View::make('users.index')->with('users', $users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get a user
        $user = User::find($id);

        if (!Auth::user()->hasPermissionTo('userListing'))
        {
            // Only allow patients to view their own profile
            if (Auth::user()->id != $id)
            {
                return redirect('/');
            }
            
        } else
        {
            // Allow physicians to view their own profile and patient profiles
            if (!Auth::user()->hasPermissionTo('admin'))
            {
                if (($user->role->role_name != 'patient') && (Auth::user()->id != $id))
                {
                    return redirect('/');
                }
            }
        }

        return View::make('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit a user
        $user = User::find($id);
        
        if (!Auth::user()->hasPermissionTo('userListing'))
        {
            // Only allow patients to edit their own profile
            if (Auth::user()->id != $id)
            {
                return redirect('/');
            }
            
        } else
        {
            // Allow physicians to edit their own profile and patient profiles
            if (!Auth::user()->hasPermissionTo('admin'))
            {
                if (($user->role->role_name != 'patient') && (Auth::user()->id != $id))
                {
                    return redirect('/');
                }
            }
        }

        $roles = Role::all();
        $availabilities = Availability::all();

        return View::make('users.edit')->with(['user' => $user, 'roles' => $roles, 'availabilities' => $availabilities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update the user
        $user = User::find($id);
        
        if (!Auth::user()->hasPermissionTo('userListing'))
        {
            // Only allow patients to update their own profile
            if (Auth::user()->id != $id)
            {
                return redirect('/');
            }
            
        } else
        {
            // Allow physicians to update their own profile and patient profiles
            if (!Auth::user()->hasPermissionTo('admin'))
            {
                if (($user->role->role_name != 'patient') && (Auth::user()->id != $id))
                {
                    return redirect('/');
                }
            }
        }

        // Check the values retrieved from the edit form
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->city = $request->input('city');

        if (Auth::user()->hasPermissionTo('admin'))
        {
            $user->role_id = $request->input('role_id');
        }
        
        $user->save();

        // Update availability
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $times = [];

        // Add times to the pivot table if the start_time is not null
        if ($start_time)
        {
            if ($end_time < $start_time)
            {
                for ($i = $start_time; $i <= 48; $i++)
                {
                    array_push($times, $i);
                    
                }
                for ($i = 1; $i <= $end_time; $i++)
                {
                    array_push($times, $i);
                }
            } else
            {
                for ($i = $start_time; $i <= $end_time; $i++)
                {
                    array_push($times, $i);
                }
            }
        }
        
        $user->availabilities()->detach();
        $user->availabilities()->attach($times);
        return redirect('users/' . $id)->with('success', 'Successfully updated user!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Deactivate the user
        $user = User::find($id);
        $user->password = '';
        $user->is_active = 0;
        $user->save();

        return redirect('users');
    }
}
