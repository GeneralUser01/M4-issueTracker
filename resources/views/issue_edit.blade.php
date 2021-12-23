@extends('layouts.issues')

@section('rightContainer')
<section class="addDetails">
    <article class="issueInformation">
        @include('inc.messages')
        <div class="fullViewTitle">Edit your post "{{$post->title}}":</div>
        <br>

        {!! Form::open(array( 'action' => ['App\Http\Controllers\IssueController@update', $project->id, $post->issue_number])) !!}
            {{Form::label('title', 'Title')}}
            <div class="titleCreation">
                {{Form::text('title', $post->title, ['class' => 'form-control', 'maxlength' => '50', 'placeholder' => 'Title'])}}
            </div>
            {{Form::label('body', 'Description')}}
            <main class="descCreation">
                {{Form::textarea('body', $post->body, ['id' => 'ckeditor', 'class' => 'form-control', 'maxlength' => '5000', 'placeholder' => 'Description'])}}
            </main>
    </article>
</section>
<div class="rightPanelBottomBox">
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Submit', ['class' => 'btnSend'])}}
</div>
        {!! Form::close() !!}
@endsection