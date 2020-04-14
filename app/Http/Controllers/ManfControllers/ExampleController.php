<?php

namespace App\Http\Controllers\ManfControllers;
use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return "ExampleController";
    }
}
