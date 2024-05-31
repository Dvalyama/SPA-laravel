<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Comment;

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
            'username' => 'required|regex:/^[A-Za-z0-9]+$/',
            'email' => 'required|email',
            'homepage' => 'nullable|url',
            'captcha' => 'required|regex:/^[A-Za-z0-9]+$/',
            'text' => 'required'
        ]);

        if ($request->input('captcha') != Session::get('captcha_text')) {
            return redirect()->back()->withErrors(['captcha' => 'Невірна CAPTCHA'])->withInput();
        }

        $allowed_tags = '<b><i><u><a>';
        $text = strip_tags($request->input('text'), $allowed_tags);

        Comment::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'homepage' => $request->input('homepage'), // Homepage is optional
            'text' => $text
        ]);

        return redirect()->route('home')->with('success', 'Коментар успішно додано');
    }

    public function captcha()
    {
        $captcha_text = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 6);
        Session::put('captcha_text', $captcha_text);

        $width = 150;
        $height = 40;
        $image = imagecreatetruecolor($width, $height);

        $bg_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

        $font = 5;
        $x = 10;
        $y = 10;
        imagestring($image, $font, $x, $y, $captcha_text, $text_color);

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
        exit;
    }
}
