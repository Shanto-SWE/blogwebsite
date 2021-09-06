<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Hash;

class UserController extends Controller
{
    function userRegistration(Request $request){
     
 
        $this->validate($request, [
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
           
        ]);
        $user=user::create([
            'name' => $request->firstName.' '.$request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password)
           
        ]);

        if($request->hasFile('image')){
            $image = $request->image;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/user/', $image_new_name);
            $user->image = '/storage/user/' . $image_new_name;
            $user->save();
        }


         Session::flash('success', 'Registration successfully');
         return redirect()->route('user.login');

    }

    function makeLogin(Request $req){
       
      $user= User::where(['email'=>$req->email])->first();
        if(!$user || !Hash::check($req->password,$user->password))
        {
            return back()->withErrors(['message'=>'invalid email or password']);
        }
        else{
            $req->session()->put('user',$user);
            return redirect('/');
        }

         
           
    }
    function loginPage(){

        return view('website.userLogin');
    }
    function registerPage(){
        return view('website.userRegister');
    }

    function logout(Request $req){

        $req->session()->forget('user');
        return redirect()->route('user.login');
    }
    function index(){
        $users = User::latest()->paginate(20);

        return view('admin.user.index', compact('users'));
    }
    function create(){
          return view('admin.user.create');

    }
    function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
        ]);

        Session::flash('success', 'User created successfully');
        return redirect()->back();
        
    }
    function edit(Request $request){
        $id=$request->id;
        $user=User::where('id',$id)->get()->first();
          return view('admin.user.edit',compact('user'));
        
    }
    function update(Request $request){
        $id = $request->id;
        // validation
        $user=user::where('id',$id)->first();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email, $user->id",
            'password' => 'sometimes|nullable|min:8',
        ]);
        $data = array(
            'name' => $request->name,
            "email"=>$request->email,
            'password'=>bcrypt($request->password),
            "description"=>$request->description,
        );
        $user = User::find($id);
        $user->update($data);
        Session::flash('success', 'User updated successfully');
        return redirect()->route('user.list');
    }
    function destroy(Request $request){
        $id=$request->id;
        $user=User::where('id',$id)->first();
        if($user){
            if(file_exists(public_path($user->image))){
                unlink(public_path($user->image));
            }

           $userdelete=User::where('id',$id)->delete();
            Session::flash('User deleted successfully');
            $request->session()->forget('user');
            return redirect()->route('user.list');
        }

    
         
        
    }
    function profile(){
  
        $userid=Session::get('user')['id'];
        $user=User::where('id',$userid)->first();
        return view('admin.user.profile',compact('user'));

    }
    function profile_update(Request $request){

    $user=Session::get('user');
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email, $user->id",
            'password' => 'sometimes|nullable|min:8',
            'image'=> 'sometimes|nullable|image|max:2048',
        ]);
        $data = array(
            'name' => $request->name,
            'email'=>$request->email,
            'description'=>$request->description,
      
        );
        if($request->has('password') && $request->password !== null){
           $data['password'] = bcrypt($request->password);
        }
        if($request->hasFile('image')){
            $image = $request->image;
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/user/', $filename);
            $data['image']= '/storage/user/' . $filename;
        }
        $profileUpdate=User::where('id',$user->id)->update($data);
     
     
        Session::flash('success', 'User profile updated successfully');
        return redirect()->back();
    }
}
