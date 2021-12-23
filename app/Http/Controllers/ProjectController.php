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

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('project_index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // replace 'desc' with 'asc' or vice versa to reverse the shown list order
        $projects = Project::orderBy('created_at', 'desc')->get();

        return view('project_create', ['projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Create project
        $project = new Project;
        $project->title = $request->input('title');
        $project->body = $request->input('body');
        $project->save();

        return redirect('/projects')->with('success', 'Project created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($projectId)
    {
        return redirect("/projects/{$projectId}/issues");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId)
    {
        $project = Project::find($projectId);
        $projects = Project::orderBy('created_at', 'desc')->get();

        return view('project_edit', [
            'project' => $project,
            'projects' => $projects
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        // Update project
        $project = Project::find($projectId);
        $project->body = $request->input('body');
        $project->save();

        return redirect("/")->with('success', 'Project updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId)
    {
        $project = Project::find($projectId);
        $project->delete();
        return redirect('/')->with('success', 'Project deleted');
    }
}