<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::paginate(5);
        return view('dashbord/category/index',compact('category'));
    }

    public function create()
    {
        return view('dashbord/category/create');
    }

    public function store(Request $request)
    {
        $fileimage = $request->file('image');
        $image= "";
        if(!empty($fileimage)){
            $image = md5(time()).".".$fileimage->getClientOriginalExtension();
            $fileimage->move('images/category',$image);
        }
        Category::create([
           'title'=>$request->title,
           'description'=> $request->description,
           'image'=>$image
        ]);
        session()->flash('create-category','create category successfully !');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category =  Category::findorfail($id);
        return view('dashbord.category.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $imagefile = $request->file('image');
        $image = "";
        if(!empty($imagefile)){
            $oldImage = Category::findorfail($id)->image;
            if(file_exists('images/category/'.$oldImage)){
                unlink('images/category/'.$oldImage);
            }
            $image = md5(time()).".".$imagefile->getClientOriginalExtension();
            $imagefile->move('images/category',$image);

        }else{
            $image = Category::findorfail($id)->image;
        }
        Category::findorfail($id)->update([
            'title'=> $request->title,
            'description' => $request->description,
            'image'=> $image
        ]);
        session()->flash('update-category','update category successfully !');
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        $image = Category::findorfail($id)->image;
        if(file_exists( 'images/category/'.$image)){
            unlink( 'images/category/'.$image);
        }
        Category::destroy($id);
        session()->flash('delete-category','delete category successfully !');
        return back();
    }
}
