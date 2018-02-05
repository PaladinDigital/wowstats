<?php

namespace WoWStats\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getUser();
        return view('welcome', $user);
    }
}
