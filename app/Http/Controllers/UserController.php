<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //show register/create form
    public function create() 

    {
        return view('users.register');
    }

    //create new user
    public function store(Request $request)

    {
        $formFields = $request->validate([

            'name'=> ['required', 'min:3'],

            'email' =>  ['required', 'email', Rule::unique('users', 'email')],
            'password'=> ['required', 'confirmed', 'min:6']
        ]);

        //hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user = User::create($formFields);

        //login

        auth()->login($user);

        return redirect('/')->with('message', 'User created successfully');
    }

    public function logout(Request $request)

    {
        auth()->logout();
        //invalidate user(for logging out) session
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/')->with('message', 'You have logged out, see you next time');
    }

    public function login()

    {
        return view('users.login');
    }
    //authenticate user
    public function authenticate(Request $request)

    {
        
        $formFields = $request->validate([

            
            'email' =>  ['required', 'email'],
            'password'=> 'required'
        ]);

        if(auth()->attempt($formFields))

        {
            $request->session()->regenerate();

            return redirect('/')->with('message', "You're logged in");
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
