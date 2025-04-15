<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $pageTitle = 'Статьи';
        $articles = Article::where('active', true)->latest('published_at')->paginate(6);
        return view('article.index', compact('articles', 'pageTitle'));
    }

    public function category($locale, $category)
    {
        $category = ArticleCategory::where('slug', $category)->firstOrFail();
        $articles = Article::where('active', true)->where('category_id', $category->id)->latest('published_at')->paginate(6);
        $pageTitle = $category->title;
        return view('article.index', compact('articles', 'category', 'pageTitle'));
    }

    public function show($locale, $category, $article)
    {
        $article = Article::where('slug', $article)->firstOrFail();
        $comments = Comment::where('article_id', $article->id)->get();
        $pageTitle = $article->title;
        return view('article.show', compact('article', 'pageTitle', 'comments'));
    }

    public function tag($locale, $tag)
    {
        $tag = Tag::where('title', $tag)->first();
    
        if ($tag) {
            $articles = $tag->articles()->where('active', true)
                                        ->latest('published_at')
                                        ->paginate(6);
    
            $pageTitle = 'Тег: ' . $tag->title;
            return view('article.index', compact('articles', 'tag', 'pageTitle'));
        } else {
            return abort(404);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query && $query == '') {
            abort(404, 'Запрос не найден');
        }

        $articles = Article::where('title', 'like', '%' . $query . '%')
            ->orWhere('detail_text', 'like', '%' . $query . '%')
            ->paginate(6);

        $pageTitle = 'Поиск: ' . $query;

        return view('article.index', compact('articles', 'query', 'pageTitle'));
    }

    public function like($locale, Article $article)
    {
        auth()->user()->articleLikes()->toggle($article);
        return back();
    }
}
