<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->mediumText('body');
            $table->unsignedInteger('issue_count')->default(0);
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->mediumText('body');
            $table->string('status');
            $table->unsignedInteger('issue_number');
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('post_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('posts')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id')->constrained('post_entries')->cascadeOnDelete();
            $table->mediumText('body');
        });
        Schema::create('title_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id')->constrained('post_entries')->cascadeOnDelete();
            $table->string('old_title');
        });
        Schema::create('status_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id')->constrained('post_entries')->cascadeOnDelete();
            $table->string('old_status');
        });



        // Maybe have custom labels?
        /*
        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
        });
        // Each issue has an array of labels:
        Schema::create('label_issue_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('label_id');
            $table->foreignId('issue_id');
        });
        */

        // Maybe have blocking issues?
        /*
        // Each issue has an array of issues that needs to be solved before it can be solved:
        Schema::create('blocking_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blocked_issue_id');
            $table->foreignId('issue_that_needs_solving_id');
        });


        // Mentions of an issue in other issues (user writes a comment with something like "See #2 for more info" to mention issue 2 inside another issue)
        /*
        Schema::create('mentions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id');
            $table->foreignId('mentioned_issue_id');
        });
        */


        // All edits for a comment (so store old comment texts)
        /*
        Schema::create('old_comment', function (Blueprint $table) {
            $table->id();
            $table->mediumText('old_body');
            $table->foreignId('current_comment_id');
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('posts');

        Schema::dropIfExists('post_entries');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('title_changes');
    }
}
