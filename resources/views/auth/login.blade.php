@extends('layouts.guest_app')

@section('content')
<div class="container">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                
                                    
                                    @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
                                @endif
                                    <form  action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" value="@if(old('email'))
                                                {{old('email')}}
                                            @endif" id="inputEmail"  name="email" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" value="@if(old('password'))
                                                {{old('password')}}
                                            @endif" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" name="remember" type="checkbox" value="" />
                                            <label class="form-check-label" >Remember Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Forgot Password?</a>
                                            <button class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
      
    </div>
</div>
@endsection
