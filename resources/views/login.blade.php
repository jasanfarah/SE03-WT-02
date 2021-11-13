@extends('master')

@section('content')
    <div
        style="background-image: url('{{ asset('imgs/login.jpg') }}'); background-size: cover; position: relative"
        class="h-100">
        <div style="position: absolute;background-color: black;height: 100%;width: 100%;opacity: 50%"></div>
        <div class="card shadow-sm"
             style="width: 500px; top: 50%;left: 50%;  transform: translate(-50%, -50%);position: absolute">
            <div class="card-header">
                <h3 class="mb-0">Login</h3>
            </div>
            <div class="card-body">
                <!-- Task 3 Guest, step 5: add the HTTP method and url as instructed-->
                <form action="{{ route('doLogin') }}" method="post">
                    @csrf
                    {{ method_field('POST') }}

                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control email" id="email" placeholder="Type your email">

                    @if($errors->has('email'))
                        <div class="form-text text-danger">{{ $errors->first('email') }}</div>
                    @endif

                    <br>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control password" id="password" placeholder="Type your password">

                    <br>

                    <div class="d-flex justify-content-between align-items-center">
                        <button class="login-submit" type="submit" value="Submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
