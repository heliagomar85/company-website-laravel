<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $post = Post::with('category')->paginate(5);
        return view('dashbord.post.index',compact('post'));
    }


    public function create()
    {
        $category = Category::pluck('title','id');
        return view('dashbord.post.create',compact('category'));
    }

    public function store(Request $request)
    {
        $file = $request->file('image');
        $image = "";
        if(!empty($file)){
            $image = md5(time()).".". $file->getClientOriginalExtension();
            $file->move('images/post',$image);

            Post::create([
                'title'=>$request->title,
                'description' => $request->description,
                'image'=> $image,
                'category_id'=>$request->category
            ]);
            session()->flash('create-post','create post successfully !');
            return back();
        }
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $allcategory = Category::pluck('title','id');
        $categoryPost = Post::with('category')->findOrFail($id);
        return view('dashbord/post/edit',compact('post','allcategory','categoryPost'));
    }
    public function update(Request $request, $id)
    {
        $fileImages = $request->file('image');
        $image = "";
        if(!empty($fileImages)){
            $lastImage = Post::findorfail($id)->image;
            if(file_exists('images/post/'. $lastImage)){
                unlink('images/post/'. $lastImage);
            }
            $image = md5(time()).'.'.$fileImages->getClientOriginalName();
            $fileImages->move('images/post',$image);

        }else{
            $image = Post::findorfail($id)->image;
        }
        Post::findorfail($id)->update([
            'title'=> $request->title,
            'description'=> $request->description,
            'image'=> $image,
            'category_id'=> $request->category
        ]);
        session()->flash('update-post','update post successfully !');
        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        $fileImages = Post::findorfail($id)->image;
        if(file_exists('images/post/'.$fileImages)){
            unlink('images/post/'.$fileImages);
        }
        Post::destroy($id);
        session()->flash('delete-post','delete post successfully !');
        return back();
    }
}
