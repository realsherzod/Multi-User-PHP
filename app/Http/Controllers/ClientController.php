<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class ClientController extends Controller
{
    public function showRegisterPage()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:clients',
            'password' => 'required|confirmed'
        ]);
        $client = Client::create([
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        auth()->guard('client')->login($client);
        return redirect()->route('client.dashboard');
    }

    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('phone', 'password');

        if (!auth()->guard('client')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationValidationException::withMessages([
                'phone' => trans('auth.failed'),
            ]);
        }
        return redirect()->route('client.dashboard');
    }


    public function logout()
    {
        auth()->guard('client')->logout();
        return redirect()->route('loginClient');
    }
}
