<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'homepage' => 'nullable|url|max:255',
            'text' => 'required|string',
            'captcha' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB limit
            'file' => 'nullable|mimes:txt|max:100', // 100KB limit
            'parent_id' => 'nullable|integer|exists:comments,id'
        ]);

        if ($request->input('captcha') != Session::get('captcha_text')) {
            return redirect()->back()->withErrors(['captcha' => 'Невірна CAPTCHA'])->withInput();
        }

        if ($request->hasFile('image')) {
            // Обробка зображення
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = public_path('images/' . $filename);
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(320, 240, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image_resize->save($path);
            $validatedData['image'] = 'images/' . $filename;
        }

        if ($request->hasFile('file')) {
            // Обробка текстового файлу
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('files/'), $filename);
            $validatedData['file'] = 'files/' . $filename;
        }

        // Додавання дати до коментаря
        $validatedData['created_at'] = Carbon::now();

        $comment = Comment::create($validatedData);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function index()
    {
        // Отримання коментарів з дочірніми коментарями
        $comments = Comment::whereNull('parent_id')->with('replies')->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'comments' => $comments]);
    }

    public function captcha(Request $request)
    {
        $captcha_text = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 6);
        $request->session()->put('captcha_text', $captcha_text);

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
        return $request;
    }
}

