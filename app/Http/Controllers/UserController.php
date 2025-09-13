<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function candidate()
    {
        $candidates = User::where('role', 'candidate')->latest()->get();

        return Inertia::render('candidate/index', ['candidates' => $candidates]);
    }
}
