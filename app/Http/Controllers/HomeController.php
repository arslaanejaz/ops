<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use JonnyW\PhantomJs\Client;

class HomeController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }


}
