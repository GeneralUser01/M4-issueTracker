<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostEntry;
use App\Models\TitleChange;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projectId, $issue_number)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();

        // Create comment
        // Do all of this or nothing
        DB::transaction(function() use ($post, $request) {
            $entry = new PostEntry;
            $entry->issue_id = $post->id;
            $entry->save();

            $comment = new Comment;
            $comment->body = $request->input('body');
            $comment->entry_id = $entry->id;
            $comment->save();
        });

        return redirect("/projects/{$projectId}/issues/{$issue_number}")->with('success', 'Comment created');
    }
}
