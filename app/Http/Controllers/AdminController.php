<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Hash;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function loginPage(){
        return view('admin.adminlogin.index');


    }

    function makeLogin(Request $req){

          $email=$req->email;
      $admin=Admin::where('email',$email)->first();
        if(!$admin || !Hash::check($req->password,$admin->password))
        {
            return back()->withErrors(['message'=>'invalid email or password']);
        }
        else{
            $req->session()->put('admin',$admin);
            return redirect()->route('dashboard');
        }
    }

    function logout(Request $req){
        $req->session()->forget('admin');
        return redirect()->route('admin.login');
    }
}
