<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusChange extends Model
{
    // Table name
    protected $table = 'status_changes';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;

    // Default snippet of code generated here
    // use HasFactory;
}
