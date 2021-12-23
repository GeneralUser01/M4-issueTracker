@extends('layouts.app')

@section('head')
<link href="{{ asset('css/issueTrackerStyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="contentFlow">

    <nav>
        <header>
            <a class="projectsHeader altLink" href="/">Projects</a>
        </header>
        <button class="logOutButton">Log in</button>
    </nav>

    <div class="itemRow">
        <div class="leftContainer">
            <section class="compactDashboard">
                @foreach($projects as $project)
                <article class="issueInformation">
                    <div class="itemRow">
                        <time class="projectDate">Published on:<br> {{$project->created_at}}</time>
                        {!! Form::open(array( 'action' => ['App\Http\Controllers\ProjectController@destroy', $project->id], 'method' => 'POST', 'class' => 'btnDelete')) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit(
'Delete project
and all of its contents
immediately',           ['class' => 'btnDelete'])}}
                        {!!Form::close()!!}
                        <form method="get" action="/projects/{{$project->id}}/edit">
                            <button type="submit" class="btnEditPost">Edit project</button>
                        </form>
                    </div>
                    <article class="projectAlignment"><a class="previewTitle" href="/projects/{{$project->id}}/issues">{{$project->title}}</a></article>
                    <article class="projectDesc">{{$project->body}}</article>
                </article>
                @endforeach
            </section>
            <form method="get" action="http://localhost:8000/projects/create">
                <button type="submit" class="btnProjectCompact">Add project</button>
            </form>
        </div>

        <div class="verticalSplitLine"></div>

        <div class="rightContainer">
            @yield('rightContainer')
        </div>

    </div>
</div>
@endsection