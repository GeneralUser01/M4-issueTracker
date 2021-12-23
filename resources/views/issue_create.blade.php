@extends('layouts.issues')

@section('rightContainer')
<section class="addDetails">
    <article class="issueInformation">
        @include('inc.messages')
        <div class="fullViewTitle">Post creation:</div>
        <br>

        {!! Form::open(['action'=> ['App\Http\Controllers\IssueController@store', $project->id]]) !!}
            {{Form::label('title', 'Title')}}
            <div class="titleCreation">
                {{Form::text('title', '', ['class' => 'form-control titleCreation',  'maxlength' => '50', 'placeholder' => 'Title'])}}
            </div>
            {{Form::label('body', 'Description')}}
            <main class="descCreation">
                {{Form::textarea('body', '', ['id' => 'ckeditor', 'class' => 'form-control', 'maxlength' => '5000', 'placeholder' => 'Description'])}}
            </main>
    </article>
</section>
<div class="rightPanelBottomBox">
    {{Form::submit('submit', ['class'=>'btnsend'])}}
</div>
{!! Form::close() !!}
@endsection