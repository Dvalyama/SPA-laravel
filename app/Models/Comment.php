<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =
        [   
            'username',
            'email',
            'homepage',
            'text',
            'image',
            'file',
            'created_at',
            'parent_id'
        ];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
