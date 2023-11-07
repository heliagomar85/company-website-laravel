<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createTeamRequest;
use App\Http\Requests\updateTeamRequest;
use App\Models\Slider;
use App\Models\Team;
use Illuminate\Http\Request;
use function view;

class TeamController extends Controller
{

    public function index()
    {
        $team = Team::paginate(5);
        return view('dashbord.team.index',compact('team'));
    }

    public function create()
    {
        return view('dashbord.team.create');
    }

    public function store(createTeamRequest $request)
    {
       $file = $request->file('image');
       $image = "";
       if(!empty($file)){
           $image = md5(time()).".".$file->getClientOriginalExtension();
           $file->move('images/team',$image);
       }
       Team::create([
           'FullName' => $request->fullname,
           'captions'=> $request->captions,
           'image'=> $image,
           'instagram'=>$request->instagram,
           'twitter'=> $request->twitter,
           'facebook'=>$request->facebook,
       ]);
       session()->flash('create-team','create team successfully');
       return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $team = Team::findorfail($id);
        return view('dashbord.team.edit',compact('team'));
    }

    public function update(updateTeamRequest $request, $id)
    {
        $fileImages = $request->file('image');
        $image = "";
        if(!empty($fileImages)){
            $lastImage = Team::findorfail($id)->image;
            if(file_exists('images/team/'. $lastImage)){
                unlink('images/team/'. $lastImage);
            }
            $image = md5(time()).'.'.$fileImages->getClientOriginalName();
            $fileImages->move('images/team',$image);

        }else{
            $image = Team::findorfail($id)->image;
        }
        Team::findorfail($id)->update([
            'FullName' => $request->FullName,
            'captions' => $request->captions,
            'instagram'=>$request->instagram,
            'twitter'=> $request->twitter,
            'facebook'=>$request->facebook,
            'image'=> $image
        ]);
        session()->flash('update-team','update team successfully !');
        return redirect()->route('team.index');


    }

    public function destroy($id)
    {
        $image = Team::findorfail($id)->image;
        if(file_exists('images/team/' . $image)){
            unlink('images/team/' . $image);
        }
        Team::destroy($id);
        session()->flash('delete-team','delete team successfully !');
        return back();
    }
}
