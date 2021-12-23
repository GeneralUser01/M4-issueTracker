<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table name
    protected $table = 'posts';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function fromIssueNumber($projectId, $issueNumber) {
        return Post::where('issue_number', '=', $issueNumber)->where('project_id', '=', $projectId)->get();
    }
    public static function withViewMode($projectId, $viewMode) {
        if ($viewMode == 'all') {
            return Post::where('project_id', '=', $projectId)->orderBy('created_at', 'desc')->get();
        } else {
            $issue_filter = '!=';
            if ($viewMode == 'closed') {
                $issue_filter = '=';
            }
            return Post::where('project_id', '=', $projectId)
                ->where('status', $issue_filter, 'closed')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function entries() {
        return $this->hasMany(PostEntry::class, 'issue_id');
    }
    // Default snippet of code generated here
    // use HasFactory;
}
