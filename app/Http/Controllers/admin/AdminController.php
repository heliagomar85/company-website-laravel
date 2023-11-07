<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createSeoRequest;
use App\Models\Seo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('dashbord.admin.index');
    }
    public function storeSeo(createSeoRequest $request){
        Seo::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'keywords' => $request->keywords,
        ]);
        session()->flash('insert-seo','seo information successfully added');
        return redirect()->route('admin.seo');
    }
    public function showDetails(){
        $seo = Seo::paginate(5);
        return view('dashbord.admin.showSeo',compact('seo'));
    }

    public function deleteSeo($id){
        Seo::destroy($id);
        session()->flash('delete-seo','delete item has successfully');
        return back();
    }
}
