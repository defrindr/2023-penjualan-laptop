<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\User;

class HomeController extends Controller
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
        $users = User::count();
        $laptops = Laptop::count();

        $widget = [
            'users' => $users,
            'laptops' => $laptops,
            //...
        ];

        return view('pages.admin.home', compact('widget'));
    }
}
