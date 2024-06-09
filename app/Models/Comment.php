<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'homepage',
        'text',
        'image',
        'file',
        'parent_id'
    ];

    public function comments()
{
    return $this->hasMany(Comment::class, 'parent_id', 'id');
}

}
