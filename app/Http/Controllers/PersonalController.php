<?php

namespace App\Http\Controllers;

use App\Http\Requests\Personal\Comment\UpdateRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'articleUserLikesCount' => $user->articleLikes()->count(),
            'articleUserCommentsCount' => $user->comments->count()
        ];

        return view('personal.index', compact('data', 'user'));
    }

    public function liked()
    {
        $user = Auth::user();
        $articles = $user->articleLikes()->get();
        return view('personal.liked', compact('articles'));
    }

    public function comment()
    {
        $comments = Auth::user()->comments;
        return view('personal.comment', compact('comments'));
    }

    public function delete($locale, Article $article)
    {
        Auth::user()->articleLikes()->detach($article->id);
        return redirect()->route('liked', [$locale]);
    }

    public function editComment($locale, Comment $comment)
    {
        return view('personal.commentEdit', compact('comment'));
    }

    public function updateComment($locale, UpdateRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment->update($data);
        return redirect()->route('comment', [$locale]);
    }

    public function deleteComment($locale, Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comment', [$locale]);
    }
}
