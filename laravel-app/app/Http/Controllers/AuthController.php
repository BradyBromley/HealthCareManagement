<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        // Check the values retrieved from the register form
        $credentials = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        // Verify that the passwords are the same
        if ($credentials['password'] == $credentials['confirm_password'])
        {
            if ($user = User::where('email', $credentials['email'])->first())
            {
                if ($user->is_active == 0) {
                    // If the email already exists but is deactivated, update the entry in the database
                    $user->first_name = $request->input('first_name');
                    $user->last_name = $request->input('last_name');
                    $user->password = Hash::make($request->input('password'));
                    $user->address = NULL;
                    $user->city = NULL;
                    $user->role_id = 4;
                    $user->is_active = 1;
                    $user->save();

                    return redirect('/auth/login')->with('success', 'Registration successful! Please log in.');
                } else 
                {
                    return redirect('/auth/register')->withErrors(['email' => 'This email already exists.'])->withInput();
                }
            } else
            {
                // If the email doesn't exist, create a new user
                User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => 4,
                    'is_active' => 1,
                ]);

                return redirect('/auth/login')->with('success', 'Registration successful! Please log in.');
            }
        } else
        {
            return redirect('/auth/register')->withErrors(['confirm_password' => 'Passwords do not match.'])->withInput();
        }
    }


    public function authenticate(Request $request): RedirectResponse
    {
        // Check the values retrieved from the login form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Verify that they are an active user
        $credentials['is_active'] = 1;

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/auth/login')->withErrors(['email' => 'The email address or password is incorrect.', 'password' => 'The email address or password is incorrect.'])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
