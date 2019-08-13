<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }

    public function show($id)
    {
        activity('show')->log('Opened user ' . $id);

        $user = User::findOrFail($id);
        return view('users.show')->with('user', $user);
    }


}
