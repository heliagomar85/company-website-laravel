<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social = Social::paginate(5);
        return view('dashbord.social.index',compact('social'));
    }

    public function create()
    {
        return view('dashbord.social.create');
    }

    public function store(Request $request)
    {
        Social::create([
            'description' =>$request->description,
            'facebook'=>$request->facebook,
            'twitter' =>$request->twitter,
            'instagram'=>$request->instagram,
            'linkedin'=>$request->linkedin,

        ]);
        session()->flash('create-social','create social successfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Social::destroy($id);
        session()->flash('delete-social','delete social successfully');
        return back();
    }
}
