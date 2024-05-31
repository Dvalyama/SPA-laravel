<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user')->get();
        return view('home', compact('comments'));
    }
}
