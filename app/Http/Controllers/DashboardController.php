<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pagetitle   = "Dashboard";
        $breadcrumbs = ["Dashboard"];
        $urls        = ['/'];
        return view('dashboard.index', compact('pagetitle', 'breadcrumbs', 'urls'));
    }
}
