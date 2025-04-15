@extends('layouts.main')

@section('content')
    <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-8 main-content">
            <img src="/uploads/{{ $article->detail_image }}" alt="{{ $article->title }}" class="img-fluid mb-5">
            <div class="post-meta">
                <span class="mr-2">{{ $article->formated_published_at }}</span>
            </div>
            <h1 class="mb-4">{{ $article->title }}</h1>
            <a class="category mb-5"
                href="{{ route('article.category', [app()->getLocale(), $article->category->slug]) }}">{{ $article->category->title }}</a>
            <div class="post-content-body">
                {!! $article->detail_text !!}
            </div>
            <section class="py-3">
                @auth
                    <form action="{{ route('article.like.store', [app()->getLocale(), $article->id]) }}" method="POST">
                        @csrf
                        <span>{{ $article->likes_count }}</span>
                        <button type="submit" class="border-0 bg-transparent">
                            @if (auth()->user()->articleLikes->contains($article))
                                <i class="fa fa-heart text-danger"></i>
                            @else
                                <i class="fa fa-heart-o"></i>
                            @endif
                        </button>
                    </form>
                @endauth
                @guest
                    <div>
                        <span>{{ $article->likes_count }}</span>
                        <i class="fa fa-heart-o"></i>
                    </div>
                @endguest
            </section>

            <div class="pt-5">
                <p>{{ __('Теги:') }}
                    @foreach ($article->tags as $tag)
                        <a href="{{ route('article.tag', [app()->getLocale(), $tag->title]) }}">#{{ $tag->title }}</a>
                    @endforeach
                </p>
            </div>

            <div>
                <section class="comment-list mb-5">
                    <h2 class="section-title mb-5" data-aos="fade-up">{{ __('Комментарии') }} ({{ $article->comments->count() }})</h2>
                    @foreach ($article->comments as $comment)
                        <div class="comment-text mb-3">
                            <span class="username">
                                <div>
                                    {{ $comment->user->name }}
                                </div>
                                <span
                                    class="text-muted float-right">{{ $comment->dateAsCarbon->diffForHumans() ?? ' ' }}</span>
                            </span>
                            {{ $comment->message }}
                        </div>
                    @endforeach
                </section>
                @auth()
                    <section class="comment-section mb-5">
                        <form action="{{ route('article.comment.store', [app()->getLocale(), $article->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12" data-aos="fade-up">
                                    <label for="comment" class="sr-only">{{ __('Комментарии') }}</label>
                                    <textarea name="message" id="comment" class="form-control" placeholder="{{ __('form.comment') }}" rows="10"></textarea>
                                </div>
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                            </div>
                            <div class="row">
                                <div class="col-12" data-aos="fade-up">
                                    <input type="submit" value="{{ __('form.submit') }}" class="btn btn-warning">
                                </div>
                            </div>
                        </form>
                    </section>
                @endauth
            </div>

        </div>

        <!-- END main-content -->

        @include('blocks.right')

    </div>
@endsection
