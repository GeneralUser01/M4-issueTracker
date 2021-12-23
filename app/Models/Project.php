<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Table name
    protected $table = 'projects';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function issues() {
        return $this->hasMany(Post::class, 'project_id');
    }
    // Default snippet of code generated here
    // use HasFactory;
}
