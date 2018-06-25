<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Hash;
use Auth;

class LoginUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	if (Auth::check()){return redirect('home');}
        return view('userlogin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
    	$this->validate($request, ['email' => 'required','password'=>'required']);

    	if (Auth::attempt(array('email' => $request->email, 'password' => $request->password)))
    	{
    		Auth::login(Auth::user(), true);
    		return redirect('home');
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['Not Correct Username Or Password.']);
    	}
    exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
