<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Catregory;
use App\Models\Tag;
use App\Models\Contact;
use Session;
use Hash;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    function home(){
        $posts = Post::with('category', 'user')->orderBy('created_at', 'DESC')->take(5)->get();
        $firstPosts2 = $posts->splice(0, 2);
        $middlePost = $posts->splice(0, 1);
        $lastPosts = $posts->splice(0);

        $footerPosts = Post::with('category', 'user')->inRandomOrder()->limit(4)->get();
        $firstFooterPost = $footerPosts->splice(0, 1);
         $firstfooterPosts2 = $footerPosts->splice(0, 2);
        $lastFooterPost = $footerPosts->splice(0, 1);

        $recentPosts = Post::with('category','user')->orderBy('created_at', 'DESC')->paginate(9);

        return view('website.home',compact(['recentPosts','posts','firstPosts2','middlePost','lastPosts','firstFooterPost','firstfooterPosts2','lastFooterPost']));
    }

    function about(){
       $admin=Admin::first();

        return view('website.about',compact('admin'));
    }
    function category($slug){

        $category = Catregory::where('slug', $slug)->first();
        if($category){
            $posts = Post::where('category_id', $category->id)->paginate(9);


            $postcount=$posts->count();
            return view('website.category', compact(['category','posts','postcount']));
        }else {
            return redirect('/');
        }
    }
    function post($slug){
        $post = Post::with('category','user')->where('slug',$slug)->first();
        $posts = Post::with('category', 'user')->inRandomOrder()->limit(3)->get();

              // More related posts
              $relatedPosts = Post::where('category_id', $post->category_id)->inRandomOrder()->take(4)->get();
              $firstRelatedPost = $relatedPosts->splice(0, 1);
              $firstRelatedPosts2 = $relatedPosts->splice(0, 2);
              $lastRelatedPost = $relatedPosts->splice(0, 1);
        $categories = Catregory::all();
        $tags = Tag::all();
        if($post){
            return view('website.post',compact(['post','posts','categories','tags','firstRelatedPost','firstRelatedPosts2','lastRelatedPost']));
        }else{
            return redirect('/');
        }


    }
    function tag($slug){

        $tag = Tag::where('slug', $slug)->first();
        if($tag){
           $posts = $tag->posts()->orderBy('created_at', 'desc')->paginate(9);
           $postcount=$posts->count();

         return view('website.tag', compact(['tag', 'posts','postcount']));
        }else {
            return redirect()->route('website');
        }
    }
    function contact(){

        return view('website.contact');
    }

   function send_message(Request $request){

   $this->validate($request, [
            'name' => 'required|max:200',
            'email' => 'required|email|max:200',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        $contact = Contact::create($request->all());

        Session::flash('success', 'Contact message send successfully');
        return redirect()->back();
    }
   


}
