<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        return view('user.index');
    }
}
