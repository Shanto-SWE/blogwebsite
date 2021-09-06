<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Str;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          // validation
          $this->validate($request, [
            'name' => 'required|unique:tags,name',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
        ]);

        Session::flash('success', 'Tag created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag,Request $request)
    {
        
        $id=$request->id;
        $tag=Tag::where('id',$id)->get()->first();
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $id = $request->id;
        $tag=Tag::where('id',$id)->first();

        // validation
     $this->validate($request, [
        'name' => "required|unique:tags,name,$tag->id",
    ]);
        $data = array(
            'name' => $request->name,
            "slug"=>Str::slug($request->name, '-'),
            "description"=>$request->description,
        );

        $category = Tag::find($id);
        $category->update($data);
        Session::flash('success', 'Tag updated successfully');
        return redirect()->route('tag.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Tag $tag)
    {
         
        $id=$request->id;
         $Catregory=Tag::find($id);
         $Catregory->delete();
         
         if($Catregory==true){
            Session::flash('success', 'Tag deleted successfully');
            return redirect()->route('tag.list');
         }
         else{
            Session::flash('fail', 'Tag deleted unsuccessfully');
            return redirect()->route('tag.create');
         }
    }
}
