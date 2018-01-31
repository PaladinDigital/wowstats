<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;

class RaidsController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getData();
        return view('raids/index', $data);
    }
}
