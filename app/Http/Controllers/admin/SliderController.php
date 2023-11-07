<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createSliderRequest;
use App\Http\Requests\createupdateRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index()
    {
        $slider = Slider::paginate(5);
        return view('dashbord.slider.index',compact('slider'));
    }


    public function create()
    {
        return view('dashbord.slider.create');
    }


    public function store(createSliderRequest $request)
    {
        $file = $request->file('image');
        $image = "";
        if(!empty($file)){
            $image = md5(time()).".". $file->getClientOriginalExtension();
            $file->move('images/slider',$image);

            Slider::create([
                'title'=>$request->title,
                'description' => $request->description,
                'image'=> $image
            ]);
            session()->flash('create-slider','create slider successfully !');
            return back();
        }

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $sliders = Slider::findorfail($id);
        return view('dashbord/slider/edite',compact('sliders'));
    }

    public function update(createupdateRequest $request, $id)
    {
        $fileImages = $request->file('image');
        $image = "";
        if(!empty($fileImages)){
            $lastImage = Slider::findorfail($id)->image;
            if(file_exists('images/slider/'. $lastImage)){
                unlink('images/slider/'. $lastImage);
            }
            $image = md5(time()).'.'.$fileImages->getClientOriginalName();
            $fileImages->move('images/slider',$image);

        }else{
            $image = Slider::findorfail($id)->image;
        }
        Slider::findorfail($id)->update([
            'title'=> $request->title,
            'description'=> $request->description,
            'image'=> $image
        ]);
        session()->flash('update-slider','update slider successfully !');
        return redirect()->route('slider.index');
    }

    public function destroy($id)
    {
        $fileImages = Slider::findorfail($id)->image;
        if(file_exists('images/slider/'.$fileImages)){
            unlink('images/slider/'.$fileImages);
        }
        Slider::destroy($id);
        session()->flash('delete-slider','delete slider successfully !');
        return back();
    }
}
