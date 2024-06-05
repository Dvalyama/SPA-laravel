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
        'created_at',
        'updated_at',
    ];
    
}
