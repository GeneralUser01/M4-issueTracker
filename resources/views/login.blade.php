<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>
<body>>
    <div class="box">
        <div class="heading">
            <h1>Allmänt ärendehanteringssystem</h1>
        </div>
        {!!Form::open(['action'=>'App\Http\Controllers\UsersController@create', 'method'=>'GET'])!!}
            <div class="userInputs">
                <div>
                    {{Form::label('title', 'Username')}}
                    {{Form::text('name', '', ['placeholder'=>'Username'])}}
                </div>
                <div>
                    {{Form::label('title', 'password')}}
                    {{Form::password('password', ['placeholder'=>'Enter your password'])}}
                </div>
                <div class="buttons">
                    {{Form::submit('log in')}}
                </div>
            </div>
        {!!Form::close()!!}
    </div>
</body>
</html>