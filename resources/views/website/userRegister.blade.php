>
@extends('layouts.layout')
@section('style')
<link rel="stylesheet" href="{{asset('loginpage/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

<link rel="stylesheet" href="{{asset('loginpage/css/style.css')}}">
@endsection

    @section('content')
     

        <!-- Sign up form -->
        <section class="signup">
       
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        @if ($errors->any())
              <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach   
              </div>
            @endif
                        <form action="{{route('userRegister')}}" method="POST"enctype="multipart/form-data" class="register-form" id="register-form">
                        @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="firstName" placeholder="Your First Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="lastName" placeholder="Your Last Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email"  placeholder="Your Email" required/>
                            </div>
                            <div class="form-group ">
                                            <label for="image"><i class="fas fa-camera"></i></label>
                                                <input type="file" name="image">
                                        </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" placeholder="Password" required/>
                            </div>
                          
                        
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{asset('loginpage/images/signup-image.jpg')}}" alt="sing up image"></figure>
                        <p>Already,Have a account <span><a href="/user/login">login In</a></span></p>
                    </div>
                   
                </div>
            </div>
        </section>

     
 

 @endsection