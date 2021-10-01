<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        // dd($this->authorize());
        // dd($permissions);
        if ($user->can('admin_dashboard') || $user->can('superadmin')) {
            return view('pages.index');
        }
        // return view('pages.index');
        abort(403);
    }
}
