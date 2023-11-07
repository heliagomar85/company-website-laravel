<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Information;
use App\Models\Post;
use App\Models\Seo;
use App\Models\Slider;
use App\Models\Social;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Contact;

class IndexController extends Controller
{
    public function index(){
        $seo = Seo::orderBy('id', 'desc')->first();
        $slider = Slider::all();
        $about = About::orderBy('id', 'desc')->first();
        $team = Team::all();
        $category = Category::limit(3)->get();
        $info = Information::orderBy('id', 'desc')->first();
        $social = Social::orderBy('id', 'desc')->first();
        return view('front.index',compact('seo','slider','about','team','category','info','social'));
    }
    public function BlogPage(){
        $allcategory = Category::all();
        $recent_post = Post::orderBy('id', 'desc')->limit(3)->offset(0)->get();
        $allpost = Post::paginate(4);
        $social = Social::orderBy('id', 'desc')->first();
        $info = Information::orderBy('id', 'desc')->first();
        return view('front.blog',compact('allcategory','recent_post','allpost','social','info'));
    }
    public function SinglePost($id){
        $allcategory = Category::all();
        $recent_post = Post::orderBy('id', 'desc')->limit(3)->offset(0)->get();
        $single_post = Post::where('id', '=',$id)->first();
        $social = Social::orderBy('id', 'desc')->first();
        $info = Information::orderBy('id', 'desc')->first();
        $comments = Comment::where('post_id', '=',$id)->get();
        return view('front.single_post',compact('allcategory','recent_post','single_post','social','info','comments'));
    }

    public function BlogCategory($id){
        $allcategory = Category::all();
        $recent_post = Post::orderBy('id', 'desc')->limit(3)->offset(0)->get();
        $allpost = Post::where('category_id', '=',$id)->paginate(5);
        $social = Social::orderBy('id', 'desc')->first();
        $info = Information::orderBy('id', 'desc')->first();
        return view('front.blog-cat',compact('allcategory','recent_post','allpost','social','info'));
    }

    public function ajaxContact(Request $request){

        Contact::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'subject' => $request->subject,
            'comment' => $request->comment
        ]);
        return '1';
    }

    public function ajaxComment(Request $request){
       Comment::create([
           'fullName' => $request->fullName,
           'email' => $request->email,
           'comment' => $request->comment,
           'post_id' =>$request->post_id
       ]);
       return '1';
    }
}
