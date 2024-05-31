<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Масив полів, які можна заповнювати масово.
     *
     * @var array
     */
    protected $fillable = ['text', 'username', 'email', 'homepage'];
}
