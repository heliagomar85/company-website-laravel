<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\front\IndexController::class,'index'])->name('show-website');
Route::get('/blog',[\App\Http\Controllers\front\IndexController::class,'BlogPage'])->name('index-blog');
Route::get('/single_post/{id}',[\App\Http\Controllers\front\IndexController::class,'SinglePost'])->name('single.post');
Route::get('/blog_category/{id}',[\App\Http\Controllers\front\IndexController::class,'BlogCategory'])->name('blog.category');




Auth::routes();
Route::middleware('auth')->prefix('/dashboard')->group(function(){
    // admin and seo
    Route::get('/admin',[\App\Http\Controllers\admin\AdminController::class,'index'])->name('admin.IndexPage');
    Route::post('/admin/store',[\App\Http\Controllers\admin\AdminController::class,'storeSeo'])->name('admin.store.seo');
    Route::get('/seo',function(){
       return view('dashbord.admin.seo');
    })->name('admin.seo');
    Route::get('/admin/showSeo',[App\Http\Controllers\Admin\AdminController::class,'showDetails'])->name('admin.show.seo');
    Route::delete('admin/delete/{id}',[\App\Http\Controllers\admin\AdminController::class,'deleteSeo'])->name('admin.delete.seo');
    // admin and seo
    // slider crud
      Route::resource('/slider',\App\Http\Controllers\admin\SliderController::class)->parameters(['slider'=>'id']);
    // end slider crud

    // about crud
    Route::resource('about',\App\Http\Controllers\admin\AboutController::class)->parameters(['about'=>'id']);
    // end about crud

    // Team crud
    Route::resource('team', \App\Http\Controllers\admin\TeamController::class)->parameters(['team'=>'id']);
   // end Team crud
    // category crud
    Route::resource('category',\App\Http\Controllers\admin\CategoryController::class)->parameters(['category'=>'id']);
    // end category crud
    // post crud
    Route::resource('post',\App\Http\Controllers\admin\PostController::class)->parameters(['post'=>'id']);
   // end post crud
    // information crud
    Route::resource('info',\App\Http\Controllers\admin\InformationController::class)->parameters(['info'=>'id']);
    // end information crud
     // social crud
    Route::resource('social',\App\Http\Controllers\admin\SocialController::class)->parameters(['social'=>'id']);
    // end social crud

    //    contact crud
    Route::resource('contact',\App\Http\Controllers\admin\ContactController::class)->parameters(['contact'=>'id']);
    Route::post('ajaxContact',[\App\Http\Controllers\front\IndexController::class,'ajaxContact'])->name('send-contact');
    //   end contact crud0

    // comment crud
    Route::post('ajaxComment',[\App\Http\Controllers\front\IndexController::class,'ajaxComment'])->name('send-comment');
   Route::resource('comment',\App\Http\Controllers\admin\CommentController::class)->parameters(['comment'=>'id']);
    // end comment crud

});
Route::get('/login',function(){
   return abort(404);
});


