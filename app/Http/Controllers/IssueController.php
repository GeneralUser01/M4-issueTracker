<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostEntry;
use App\Models\StatusChange;
use App\Models\TitleChange;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $project = Project::findOrFail($projectId);

        $posts = DB::table('posts')
            ->where('status', '!=', 'closed')
            ->where('project_id', '=', $projectId)->orderBy('created_at', 'desc')
            ->get();

        return view('issue_index', [
            'project' => $project,
            'posts' => $posts,
            'viewMode' => 'open',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectId)
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $project = Project::findOrFail($projectId);
        $posts = Post::where('project_id', '=', $projectId)->orderBy('created_at', 'desc')->get();

        return view('issue_create', [
            'project' => $project,
            'posts' => $posts,
            'viewMode' => 'all',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projectId)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        $project = Project::findOrFail($projectId);

        // Create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->status = 'unassigned';
        $post->project_id = $projectId;
        $post->issue_number = $project->issue_count + 1;

        $project->issue_count += 1;

        // Don't update issue count unless an issue is actually created:
        DB::transaction(function () use ($project, $post) {
            $post->save();
            $project->save();
        });

        return redirect("/projects/{$projectId}/issues/{$post->issue_number}")->with('success', 'Issue created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, $issue_number)
    {
        return $this->internalShow($projectId, $issue_number, 'open');
    }
    public function showClosed($projectId, $issue_number)
    {
        return $this->internalShow($projectId, $issue_number, 'closed');
    }
    public function showAll($projectId, $issue_number)
    {
        return $this->internalShow($projectId, $issue_number, 'all');
    }
    public function internalShow($projectId, $issue_number, $viewMode)
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $project = Project::findOrFail($projectId);
        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();

        $posts = Post::withViewMode($projectId, $viewMode);

        $entries = DB::table('post_entries')
            ->where('issue_id', '=', $post->id)
            ->orderBy('created_at', 'asc')
            ->leftJoin('status_changes', 'post_entries.id', '=', 'status_changes.entry_id')
            ->leftJoin('title_changes', 'post_entries.id', '=', 'title_changes.entry_id')
            ->leftJoin('comments', 'post_entries.id', '=', 'comments.entry_id')
            ->get();

        // Move all entries into objects (store the entry as 'value' and then add some extra stuff like 'type') to make view logic simpler:
        $entries_with_info = [];
        $prev_title_change = (object)[];
        $prev_status_change = (object)[];
        foreach ($entries as $entry) {
            if ($entry->body != null) {
                array_push($entries_with_info, (object)['type' => 'comment', 'value' => $entry]);
                continue;
            }
            if ($entry->old_title != null) {
                $prev_title_change->new_title = $entry->old_title;

                $info = (object)['type' => 'title_change', 'value' => $entry];
                $prev_title_change = $info;
                array_push($entries_with_info, $info);
                continue;
            }
            if ($entry->old_status != null) {
                $prev_status_change->new_status = $entry->old_status;

                $info = (object)['type' => 'status_change', 'value' => $entry];
                $prev_status_change = $info;
                array_push($entries_with_info, $info);
                continue;
            }
            // Debug unknown database values:
            // var_dump($entry);
        }

        $prev_title_change->new_title = $post->title;
        $prev_status_change->new_status = $post->status;

        return view('issue_show', [
            'project' => $project,
            'posts' => $posts,
            'post' => $post,
            'issue_entries' => $entries_with_info,
            'viewMode' => $viewMode,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId, $issue_number)
    {
        return $this->internalEdit($projectId, $issue_number, 'open');
    }
    public function editClosed($projectId, $issue_number)
    {
        return $this->internalEdit($projectId, $issue_number, 'closed');
    }
    public function editAll($projectId, $issue_number)
    {
        return $this->internalEdit($projectId, $issue_number, 'all');
    }

    public function internalEdit($projectId, $issue_number, $viewMode)
    {
        $project = Project::findOrFail($projectId);
        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();

        $posts = Post::withViewMode($projectId, $viewMode);

        return view('issue_edit', [
            'project' => $project,
            'posts' => $posts,
            'post' => $post,
            'viewMode' => $viewMode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $issue_number)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $newTitle = $request->input('title');

        // Update post
        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();
        // Do all of this or none of it:
        DB::transaction(function () use ($post, $newTitle, $request) {

            if ($post->title != $newTitle) {
                $entry = new PostEntry;
                $entry->issue_id = $post->id;
                $entry->save();

                $change = new TitleChange;
                $change->old_title = $post->title;
                $change->entry_id = $entry->id;
                $change->save();
            }

            $post->title = $newTitle;
            $post->body = $request->input('body');
            $post->save();
        });


        $viewMode = 'issues';
        if ($post->status == 'closed') {
            $viewMode = 'closed';
        }

        return redirect("/projects/{$projectId}/{$viewMode}/{$issue_number}")->with('success', 'Issue updated');
    }


    public function changeStatus(Request $request, $projectId, $issue_number)
    {
        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();

        $oldStatus = $post->status;
        switch ($request->input('action')) {
            case 'option-wip':
                $post->status = 'wip';
                break;
            case 'option-onHold':
                $post->status = 'onHold';
                break;
            case 'option-unassigned':
                $post->status = 'unassigned';
                break;
            case 'option-closed':
                $post->status = 'closed';
                break;
        }
        if ($oldStatus != $post->status) {
            // Do all of this or none of it:
            DB::transaction(function () use ($post, $oldStatus) {
                $entry = new PostEntry;
                $entry->issue_id = $post->id;
                $entry->save();

                $change = new StatusChange;
                $change->old_status = $oldStatus;
                $change->entry_id = $entry->id;
                $change->save();

                $post->save();
            });
        }

        $viewMode = 'issues';
        if ($post->status == 'closed') {
            $viewMode = 'closed';
        }
        return redirect("/projects/{$projectId}/{$viewMode}/{$issue_number}")->with('success', 'Status updated');
    }

    public function closed($projectId)
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $project = Project::findOrFail($projectId);

        $posts = DB::table('posts')
            ->where('status', '=', 'closed')
            ->where('project_id', '=', $projectId)->orderBy('created_at', 'desc')
            ->get();

        return view('issue_index', [
            'project' => $project,
            'posts' => $posts,
            'viewMode' => 'closed',
        ]);
    }

    public function all($projectId)
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $project = Project::findOrFail($projectId);
        $posts = Post::where('project_id', '=', $projectId)->orderBy('created_at', 'desc')->get();
        return view('issue_index', [
            'project' => $project,
            'posts' => $posts,
            'viewMode' => 'all',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $issue_number)
    {
        $post = Post::fromIssueNumber($projectId, $issue_number)->firstOrFail();
        $post->delete();
        return redirect("/projects/{$projectId}/issues")->with('success', 'Issue deleted');
    }
}
