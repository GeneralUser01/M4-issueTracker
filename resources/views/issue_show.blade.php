@extends('layouts.issues')

@section('rightContainer')
<section class="details">
    <article class="issueInformation">
        @include('inc.messages')
        <div class="fullViewTitle">{{$post->title}}</div>
        <div class="itemRow">
            <div class="fullViewAuthor">Published by:<br> (Insert username here)</div>
            <time class="fullViewDate">Published on:<br> {{$post->created_at}}</time>
            <label class="statusLabel">Post status:<br>
                <div class="btn-group fullViewStatus">
                    <button type="button" class="dropdown-toggle currentStatusContainer addonStatusContainerWide" data-toggle="dropdown">
                        <div class="statusDot {{$post->status}}"></div>
                        <span class="statusSelectionIndicator"></span>
                    </button>
                    @include('inc.change_status', ['isWide' => true])
                </div>
            </label>
            {!! Form::open(array( 'action' => ['App\Http\Controllers\IssueController@destroy', $project->id, $post->issue_number], 'method' => 'POST', 'class' => 'btnDelete')) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit(
'Delete post
and all of its sub-posts
immediately',                 ['class' => 'btnDelete'])}}
            {!!Form::close()!!}
            <form method="get" action="/projects/{{$project->id}}/{{$viewMode == 'all' ? 'all' : ($viewMode == 'closed' ? 'closed' : 'issues')}}/{{$post->issue_number}}/edit">
                <button type="submit" class="btnEditPost">Edit post</button>
            </form>
        </div>
        <main class="desc">{!!$post->body!!}</main>
    </article>
    <article class="commentSection">

        @foreach($issue_entries as $entry)
            <div class="entry" data-entry-type={{$entry->type}}>
                <time class="date">{{$entry->value->created_at}}</time>
                    @if($entry->type == 'comment')
                        <div class="content">{{$entry->value->body}}</div>
                    @endif
                    @if($entry->type == 'title_change')
                        <div class="content">The issue title was changed from <i>"{{$entry->value->old_title}}"</i> to <i>"{{$entry->new_title}}"</i></div>
                    @endif
                    @if($entry->type == 'status_change')
                        <div class="content">The issue status was changed from <i>"{{$entry->value->old_status}}"</i> to <i>"{{$entry->new_status}}"</i></div>
                    @endif
            </div>
        @endforeach

    </article>
</section>
{!! Form::open(array('action' => ['App\Http\Controllers\CommentController@store', $project->id, $post->issue_number], 'method' => 'POST', 'class'=>'rightPanelBottomBox')) !!}

{{Form::textarea('body', '', ['id' => 'ckeditor', 'class' => 'form-control commentInputArea',  'maxlength' => '5000', 'placeholder' => 'Write your comment here!'])}}

{{Form::submit('Send message', ['class'=>'btnSend'])}}

{!! Form::close() !!}
@endsection
