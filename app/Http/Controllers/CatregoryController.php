<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Support\Str;
use App\Models\Catregory;
use Illuminate\Http\Request;

class CatregoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $categories = Catregory::orderBy('created_at', 'DESC')->paginate(20);
       return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
        'name' => 'required|unique:catregories,name',
    ]);

    $category = Catregory::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name, '-'),
        'description' => $request->description,
    ]);

    Session::flash('success', 'Category created successfully');

    return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catregory  $catregory
     * @return \Illuminate\Http\Response
     */
    public function show(Catregory $catregory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catregory  $catregory
     * @return \Illuminate\Http\Response
     */
    public function edit(Catregory $catregory,Request $request)


    {

        $id=$request->id;
      $categories=Catregory::where('id',$id)->get()->first();
        return view('admin.category.edit',compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catregory  $catregory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catregory $catregory)
    {
        $id = $request->id;
        // validation
        $catrgory=Catregory::where('id',$id)->first();
     $this->validate($request, [
        'name' => "required|unique:catregories,name,$catrgory->id",
    ]);
        $data = array(
            'name' => $request->name,
            "slug"=>Str::slug($request->name, '-'),
            "description"=>$request->description,
        );

        $category = Catregory::find($id);
        $category->update($data);
        Session::flash('success', 'Category updated successfully');
        return redirect()->route('category.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catregory  $catregory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Catregory $catregory)
    {
  

     
        $id=$request->id;
         $Catregory=Catregory::find($id);
         $Catregory->delete();
         
         if($Catregory==true){
            Session::flash('success', 'Category deleted successfully');
            return redirect()->route('category.list');
         }
         else{
            Session::flash('fail', 'Category deleted unsuccessfully');
            return redirect()->route('category.create');
         }

      
    }
}
