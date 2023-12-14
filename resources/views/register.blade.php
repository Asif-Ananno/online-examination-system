@extends('layout/layout-common')
@section('space-work')

    <div class="register-container">
        <div class="register-card">
            <h1>Register</h1>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <p class="error-message">{{$error}}</p>
                @endforeach
            @endif

            <form action="{{route('studentRegister')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter password again" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Register</button>
                </div>
                <a href="/login">Already Have an account?</a>
            </form>

            @if(Session::has('success'))
                <p class="success-message">{{Session::get('success')}}</p>
            @endif
        </div>
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

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .register-card {
            background-color: #b3cde0;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
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
            padding: 15px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>

@endsection
