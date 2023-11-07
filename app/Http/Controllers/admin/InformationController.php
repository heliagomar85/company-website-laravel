<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{

    public function index()
    {
        $info = Information::paginate(5);
        return view('dashbord.info.index',compact('info'));
    }

    public function create()
    {
        return view('dashbord.info.create');
    }

    public function store(Request $request)
    {
        Information::create([
           'info' =>$request->information,
           'phone'=>$request->phone_number,
           'email' =>$request->email,
           'work'=>$request->work
        ]);
        session()->flash('create-info','create information successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
      Information::destroy($id);
        session()->flash('delete-info','delete information successfully');
        return back();
     }
}
