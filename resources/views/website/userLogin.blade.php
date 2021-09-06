
@extends('layouts.layout')
@section('style')
<link rel="stylesheet" href="{{asset('loginpage/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

<link rel="stylesheet" href="{{asset('loginpage/css/style.css')}}">
@endsection

    @section('content')
       <!-- Sing in  Form -->
       <section class="sign-in">
      
            <div class="container">
                <div class="signin-content">
                    
                    <div class="signin-image">
                        <figure><img src="{{asset('loginpage/images/signin-image.jpg')}}" alt="sing up image"></figure>
                       
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        @if ($errors->any())
              <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach   
              </div>
            @endif
                        <form method="POST"  action="{{route('user.makeLogin')}}" 
                    
                        class="register-form" id="login-form">
                        @csrf
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email"  placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" placeholder="Password" required/>
                            </div>
                         
                            <div class="form-group form-button">
                                <input type="submit"   class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

     
     
 

 @endsection