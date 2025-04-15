<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalController;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Barryvdh\TranslationManager\Controller as TranslationController;

Route::get('/', function () {
    $locale = App::getLocale();
    return redirect()->to("/$locale");
});
Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/personal', [PersonalController::class, 'index'])->name('personal');
    Route::get('/liked', [PersonalController::class, 'liked'])->name('liked');
    Route::delete('/{post}', [PersonalController::class, 'delete'])->name('delete');
    Route::get('/personal/comment', [PersonalController::class, 'comment'])->name('comment');
    Route::get('personal/comment/{comment}/edit', [PersonalController::class, 'editComment'])->name('personal.comment.edit');
    Route::patch('personal/comment/{comment}', [PersonalController::class, 'updateComment'])->name('personal.comment.update');
    Route::delete('personal/comment/{comment}', [PersonalController::class, 'deleteComment'])->name('personal.comment.delete');
    Route::get('/blog', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/blog/{category}', [ArticleController::class, 'category'])->name('article.category');
    Route::get('/blog/tag/{tag}', [ArticleController::class, 'tag'])->name('article.tag');
    Route::get('/search/', [ArticleController::class, 'search'])->name('article.search');
    Route::get('/blog/{category}/{article}', [ArticleController::class, 'show'])->name('article.show');
    Route::post('/articles/{article}/like', [ArticleController::class, 'like'])->name('article.like.store');
    Route::post('/articles/{article}/comment', [CommentController::class, 'store'])->name('article.comment.store');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
Route::group([
    'prefix' => 'translations',
    'middleware' => ['web'],
], function () {
    Route::get('/', [\Barryvdh\TranslationManager\Controller::class, 'index'])->name('translations.index');
    Route::post('/import', [\Barryvdh\TranslationManager\Controller::class, 'postImport'])->name('translations.import');
    Route::post('/find', [\Barryvdh\TranslationManager\Controller::class, 'postFind'])->name('translations.find');
    Route::post('/export', [\Barryvdh\TranslationManager\Controller::class, 'postExport'])->name('translations.export');
});

Auth::routes();
