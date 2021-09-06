<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Post;
use App\Models\Catregory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Catregory::all();
        return view('admin.post.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts,title',
            'image' => 'required|image',
            'description' => 'required',
            'category' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image' => 'image.jpg',
            'description' => $request->description,
            'category_id' => $request->category,
            'user_id' => Session::get('user')['id'],
            'published_at' => Carbon::now(),
        ]);
        $post->tags()->attach($request->tags);


        if($request->hasFile('image')){
            $image = $request->image;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/post/', $image_new_name);
            $post->image = '/storage/post/' . $image_new_name;
            $post->save();
        }

        Session::flash('success', 'Post created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Request $request)
    {
        $id=$request->id;
        $post=Post::where('id',$id)->first();
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Request $request)
    {
        $tags = Tag::all();
        $id=$request->id;
        $categories = Catregory::all();
        $post=Post::where('id',$id)->get()->first();
        return view('admin.post.edit',compact(['post', 'categories','tags']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $id = $request->id;
        $post=Post::where('id',$id)->first();
     
        $this->validate($request, [
            'title' => "required|unique:posts,title, $post->id",
            'description' => 'required',
            'category' => 'required',
        ]);
        $data = array(
            'title' => $request->title,
            'slug'=>Str::slug($request->title, '-'),
            'description'=>$request->description,
            'category_id'=>$request->category,
        );
        $post->tags()->sync($request->tags);
   
        if($request->hasFile('image')){
            $image = $request->image;
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/post/', $fileName);
            $data['image']='/storage/post/' . $fileName;
        
        }
         

      $postUpdate=Post::where('id',$id)->update($data);
     
        Session::flash('success', 'Post updated successfully');
        return redirect()->route('post.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Post $post)
    {

        $id=$request->id;
        $post=Post::where('id',$id)->first();
        if($post){
            if(file_exists(public_path($post->image))){
                unlink(public_path($post->image));
            }

           $postdelte=Post::where('id',$id)->delete();
            Session::flash('Post deleted successfully');
            return redirect()->route('post.list');
        }
   
    }
}
