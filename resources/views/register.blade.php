<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>
<body>
    <div class="box">
        <div class="heading">
            <h1>Allmänt ärendehanteringssystem</h1>
        </div>
        {!!Form::open(['action'=>'App\Http\Controllers\UsersController@store', 'method' => 'POST'])!!}
            <div class="userInputs">
                <div>
                    {{Form::label('title', 'Username')}}
                    {{-- {{Form::text('title')}} --}}
                    {{Form::text('name', '', ['placeholder'=>'Enter your name'])}}
                </div>
                <div>
                    {{Form::label('title', 'E-mail Adress')}}
                    {{-- {{Form::text('title')}} --}}
                    {{Form::email('email', '', ['placeholder'=>'Enter your E-mail'])}}
                </div>
                <div>
                    {{Form::label('title', 'password')}}
                    {{Form::password('password', ['placeholder'=>'Enter a password'])}}
                </div>
                <div>
                    {{Form::label('title', 'Confirm password')}}
                    {{Form::password('confirm_password', ['placeholder'=>'Confirm password'])}}
                </div>
            </div>
            {{Form::submit('register')}}
        {!!Form::close()!!} 
    </div>
</body>
</html>