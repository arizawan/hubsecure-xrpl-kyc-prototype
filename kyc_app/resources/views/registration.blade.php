@extends('layout')
@section('title','Login/Register')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3 login-heading">
      <h1 class="text-center mt-5">KYC Form</h2>
      <div class="text-center mb-5">Secure with Blockchain</div>
      <div class="card my-5">
        <div class="mt-1">
            @if($errors->any())
              <div class="col-12">
                @foreach($errors->all() as $error)
                  <div class="alert alert-danger">{{$error}}</div>
                @endforeach
              </div>
            @endif

            @if(session()->has('error'))
              <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            @if(session()->has('success'))
              <div class="alert alert-success">{{session('success')}}</div>
            @endif
        </div>
        <form class="card-body cardbody-color p-lg-5" action="{{route('registration.post')}}" id="kyc-upload" method="post" >
          @csrf
          <div class="text-center mb-5">
            <img src="{{ asset('img/logo.svg') }}" class="img-fluid my-3"
              alt="profile">
          </div>
          <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" id="name" class="form-control" name="name" required>

          </div>
          <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" class="form-control" name="email" required>

          </div>
          <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" id="password" class="form-control" name="password" required>

          </div>


          <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Register</button></div>
          <div id="retieve" class="form-text text-center mb-1 text-dark">Allready
            registered? <a href="{{ url('') }}" class="text-dark fw-bold">Login</a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
