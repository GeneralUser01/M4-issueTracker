<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Table name
    protected $table = 'comments';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;

    /* When/if we have authentication
    public function user() {
        return $this->belongsTo('App\User');
    }
    */
    // Default snippet of code generated here
    // use HasFactory;
}
