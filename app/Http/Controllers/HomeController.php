<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale){
        $pageTitle = 'Главная';
        $articles = Article::where('active', true)->latest('published_at')->paginate(6);
        return view('index', compact('articles', 'pageTitle'));
    }
}
