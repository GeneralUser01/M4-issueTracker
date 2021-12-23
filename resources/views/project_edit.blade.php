@extends('layouts.projects')

@section('rightContainer')
<section class="addDetails">
    <article class="issueInformation">
        @include('inc.messages')
        <div class="fullViewTitle">Edit your project "{{$project->title}}":</div>
        <br>

        {!! Form::open(['action' => ['App\Http\Controllers\ProjectController@edit', $project->id]]) !!}
            {{Form::label('body', 'Description:', ['class' => 'descCreationLabel'])}}
            <main class="descCreation">
                {{Form::textarea('body', $project->body, ['id' => 'ckeditor', 'class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Description'])}}
            </main>
    </article>
</section>
<div class="rightPanelBottomBox">
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('submit', ['class'=>'btnSend'])}}
</div>
        {!! Form::close() !!}
@endsection