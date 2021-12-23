@extends('layouts.app')

@section('head')
<link href="{{ asset('css/issueTrackerStyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="contentFlow">

    <nav>
        <header>
            <a class="goBack altLink" href="/"></a>
            <a class="projectName altLink" href="/projects/{{$project->id}}/issues">{{$project->title}}</a>
        </header>
        <button class="logOutButton">Log in</button>
    </nav>

    <div class="itemRow">
        <div class="leftContainer">
            <section class="compactDashboard">
                @yield('warning')
                @foreach($posts as $post)
                    <article>
                        <a class="previewTitle" href="/projects/{{$project->id}}/{{$viewMode == 'all' ? 'all' : ($viewMode == 'closed' ? 'closed' : 'issues')}}/{{$post->issue_number}}">{{$post->title}}</a>
                        <time class="previewDate">{{$post->created_at}}</time>
                        <div class="btn-group status">
                            <button type="button" class="dropdown-toggle currentStatusContainer" data-toggle="dropdown">
                                <div class="statusDot {{$post->status}}"></div>
                                <span class="statusSelectionIndicator"></span>
                            </button>

                            @include('inc.change_status')
                        </div>
                    </article>
                @endforeach
            </section>
            <div class="itemRow">
                <form method="get" action="/projects/{{$project->id}}/issues/create">
                    <button type="submit" class="btnissue">Add issue</button>
                </form>
                @if($viewMode == 'all')
                <form method="get" action="/projects/{{$project->id}}/issues">
                    <button type="submit" class="btnAllIssues">View open issues</button>
                </form>
                @else
                <form method="get" action="/projects/{{$project->id}}/all">
                    <button type="submit" class="btnAllIssues">View all issues</button>
                </form>
                @endif

                @if($viewMode != 'closed')
                <form method="get" action="/projects/{{$project->id}}/closed">
                    <button class="btnclosedIssues">View closed issues</button>
                </form>
                @else
                <form method="get" action="/projects/{{$project->id}}/issues">
                    <button class="btnclosedIssues">View open issues</button>
                </form>
                @endif
            </div>
        </div>

        <div class="verticalSplitLine"></div>

        <div class="rightContainer">
            @yield('rightContainer')
        </div>

    </div>
</div>
@endsection