@extends('layouts.projects')

@section('rightContainer')
<section class="addDetails">
    <article class="issueInformation">
        @include('inc.messages')
        <div class="fullViewTitle">Project creation:</div>
        <br>

        {!! Form::open(['action'=>'App\Http\Controllers\ProjectController@store']) !!}
            {{Form::label('title', 'Title:', ['class' => 'titleCreationLabel'])}}
            <div>
                {{Form::text('title', '', ['class' => 'form-control titleCreation', 'maxlength' => '50', 'placeholder' => 'Title'])}}
            </div>
            {{Form::label('body', 'Description:', ['class' => 'descCreationLabel'])}}
            <main class="projectDescCreation">
                {{Form::textarea('body', '', ['id' => 'ckeditor', 'class' => 'form-control projectDescCreation', 'maxlength' => '500', 'placeholder' => 'Description'])}}
            </main>
    </article>
</section>
<div class="rightPanelBottomBox">
    {{Form::submit('submit', ['class'=>'btnsend'])}}
</div>
{!! Form::close() !!}
@endsection