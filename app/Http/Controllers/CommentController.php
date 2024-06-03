<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('home', compact('comments'));
    }

    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|max:255',
        'email' => 'required|email|max:255',
        'homepage' => 'nullable|url|max:255',
        'text' => 'required',
    ]);

    // Логіка для збереження коментаря
    Comment::create($request->all());

    return response()->json(['success' => true]);
}

    
}
