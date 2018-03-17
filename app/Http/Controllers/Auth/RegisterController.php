<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use function view;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
