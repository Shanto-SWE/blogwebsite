<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\Post;
use\App\Models\Catregory;
use\App\Models\Tag;
use\App\Models\User;

class DeashboardController extends Controller
{
    function index(){
        $posts = Post::orderBy('created_at', 'DESC')->take(10)->get();
        $postCount = Post::all()->count();
        $categoryCount = Catregory::all()->count();
        $tagCount = Tag::all()->count();
        $userCount = User::all()->count();


        return view('admin.dashboard.index', compact(['posts', 'postCount', 'categoryCount', 'tagCount', 'userCount']));
  
    }
}
