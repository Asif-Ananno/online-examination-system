@extends('layout/layout-common')
@section('space-work')

    <div class="login-container">
        <h1>Login</h1>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="error-message">{{$error}}</p>
            @endforeach
        @endif

        @if(Session::has('error'))
            <p class="error-message">{{Session::get('error')}}</p>
        @endif

        <form action="{{route('userlogin')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info">Login</button>
            </div>
        </form>
        <a href="/register">Do not have an account?</a>
    </div>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: rgb(179,205,224);
            background: linear-gradient(135deg, rgba(179,205,224,1) 21%, rgba(1,31,75,1) 90%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }


        .login-container {
            background-color: #b3cde0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>

@endsection
