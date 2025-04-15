<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'article_id' => 'required|exists:articles,id'
        ]);

        Comment::create([
            'message' => $request->message,
            'article_id' => $request->article_id,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Комментарий успешно добавлен');
    }
}