<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['username', 'email', 'homepage', 'text', 'image', 'file', 'parent_id'];


    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}

