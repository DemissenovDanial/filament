@extends('layouts.main')

@section('content')
    @if (isset($category))
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-4">Категория: {{ $category->title }}</h2>
            </div>
        </div>
    @endif

    @if (isset($tag))
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-4">Тег: {{ $tag }}</h2>
            </div>
        </div>
    @endif

    @if (isset($query))
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-4">Поиск: {{ $query }}</h2>
            </div>
        </div>
    @endif

    @if (isset($query) && count($articles) == 0)
        <div class="not-found">По вашему запросу ничего не найдено</div>
    @endif

    <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
            <div class="row mb-5 mt-5">
                <div class="col-md-12">
                    @foreach ($articles as $article)
                        <div class="post-entry-horzontal">
                            <a href="{{ route('article.show', [$article->category->slug, $article->slug]) }}">
                                <div class="image element-animate" data-animate-effect="fadeIn"
                                    style="background-image: url(/uploads/{{ $article->preview_image }});"></div>
                                <span class="text">
                                    <div class="post-meta">
                                        <span class="mr-2">{{ $article->formated_published_at }}</span> &bullet;
                                        <span class="mr-2">{{ $article->category->title }}</span> &bullet;
                                    </div>
                                    <h2>{{ $article->title }}</h2>
                                    <div class="preview_text mr-2 mt-3">{{ $article->preview_text }}</div>
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    {{ $articles->links('vendor.pagination.custom') }}
                </div>
            </div>



        </div>

        <!-- END main-content -->

        @include('blocks.right')

    </div>
@endsection
