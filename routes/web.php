<?php

use Illuminate\Support\Facades\Route;
use\App\Http\Controllers\DeashboardController;
use\App\Http\Controllers\CatregoryController;
use\App\Http\Controllers\TagController;
use\App\Http\Controllers\PostController;
use\App\Http\Controllers\BaseController;
use\App\Http\Controllers\UserController;
use\App\Http\Controllers\AdminController;
use\App\Http\Controllers\SettingController;
use\App\Http\Controllers\ContactController;

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



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/',[BaseController::class,'home'])->name('website');
// user login and registration
Route::get('/user/login',[UserController::class,'loginPage'])->name('user.login');
Route::post('/user/login',[UserController::class,'makeLogin'])->name('user.makeLogin');
Route::get('/user/register',[UserController::class,'registerPage'])->name('user.registerPage');
Route::post('/user/register',[UserController::class,'userRegistration'])->name('userRegister');
Route::get('/user/logout',[UserController::class,'logout'])->name('user.logout');

// website route
Route::group(['prefix' => 'user'], function () {

    Route::get('/category/{slug}',[BaseController::class,'category'])->name('website.category');
    Route::get('/post/{slug}',[BaseController::class,'post'])->name('website.post');
    Route::get('/about',[BaseController::class,'about'])->name('website.about');
    Route::get('/contact',[BaseController::class,'contact'])->name('website.contact');
    Route::post('/contact',[BaseController::class,'send_message'])->name('website.send_message');
    Route::get('/tag/{slug}',[BaseController::class,'tag'])->name('website.tag');


});


// admin route
Route::get('/admin/login',[AdminController::class,'loginPage'])->name('admin.login');
Route::post('/admin/login',[AdminController::class,'makeLogin'])->name('admin.makeLogin');
Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');




Route::group(['prefix' => 'admin','middleware'=>'adminlogincheck'], function () {
    Route::get('dashboard',[DeashboardController::class,'index'])->name('dashboard');
  

    // user
    Route::get('user',[UserController::class,'index'])->name('user.list');
    Route::get('user/create',[UserController::class,'create'])->name('user.create');
    Route::post('user/store',[UserController::class,'store'])->name('user.store');
    Route::get('user/adit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::post('user/update/{id}',[UserController::class,'update'])->name('user.update');
    Route::post('user/delete/{id}',[UserController::class,'destroy'])->name('user.destroy');
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::post('user/profile/update',[UserController::class,'profile_update'])->name('user.profile.update');

    // category
    Route::get('category',[CatregoryController::class,'index'])->name('category.list');
    Route::get('category/create',[CatregoryController::class,'create'])->name('category.create');
    Route::post('category/store',[CatregoryController::class,'store'])->name('category.store');
    Route::get('category/adit/{id}',[CatregoryController::class,'edit'])->name('category.edit');
    Route::post('category/update/{id}',[CatregoryController::class,'update'])->name('category.update');
    Route::post('category/delete/{id}',[CatregoryController::class,'destroy'])->name('category.delete');
    Route::get('category/show',[CatregoryController::class,'show'])->name('category.show');

//    tages
Route::get('tags',[TagController::class,'index'])->name('tag.list');
Route::get('tag/create',[TagController::class,'create'])->name('tag.create');
Route::post('tag/store',[TagController::class,'store'])->name('tag.store');
Route::get('tag/adit/{id}',[TagController::class,'edit'])->name('tag.edit');
Route::post('tag/update/{id}',[TagController::class,'update'])->name('tag.update');
Route::post('tag/delete/{id}',[TagController::class,'destroy'])->name('tag.delete');
Route::get('tag/show',[TagController::class,'show'])->name('tag.show');

// post
Route::get('post',[PostController::class,'index'])->name('post.list');
Route::get('post/create',[PostController::class,'create'])->name('post.create');
Route::post('post/store',[PostController::class,'store'])->name('post.store');
Route::get('post/adit/{id}',[PostController::class,'edit'])->name('post.edit');
Route::post('post/update/{id}',[PostController::class,'update'])->name('post.update');
Route::post('post/delete/{id}',[PostController::class,'destroy'])->name('post.delete');
Route::get('post/show/{id}',[PostController::class,'show'])->name('post.show');

// setting
Route::get('setting',[SettingController::class,'edit'])->name('setting.index');
Route::post('setting',[SettingController::class,'update'])->name('setting.update');

    // Contact message
    Route::get('/contact', [ContactController::class,'index'])->name('contact.index');
    Route::get('/contact/show/{id}', [ContactController::class,'show'])->name('contact.show');
    Route::delete('/contact/delete/{id}', [ContactController::class,'destroy'])->name('contact.destroy');

});


