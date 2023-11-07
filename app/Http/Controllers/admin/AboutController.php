<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createAboutRequest;
use App\Models\About;
use App\Models\Slider;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    public function index()
    {
        $about = About::paginate(5);
        return view('dashbord.about.index',compact('about'));
    }

    public function create()
    {
        return view('dashbord.about.create');
    }

    public function store(createAboutRequest $request)
    {
        $file = $request->file('image');
        $image = "";
        if(!empty($file)){
            $image = md5(time()).".". $file->getClientOriginalExtension();
            $file->move('images/about',$image);

            About::create([
                'title'=>$request->title,
                'description' => $request->description,
                'image'=> $image
            ]);
            session()->flash('create-about','create about successfully !');
            return back();
        }
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
        $fileImages = About::findorfail($id)->image;
        if(file_exists('images/about/'.$fileImages)){
            unlink('images/about/'.$fileImages);
        }
        About::destroy($id);
        session()->flash('delete-about','delete about successfully !');
        return back();
    }
}
