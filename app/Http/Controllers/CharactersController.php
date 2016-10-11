<?php namespace WoWStats\Http\Controllers;

class CharactersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->getData();
        return view('home', $data);
    }
}
