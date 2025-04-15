<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ml-auto">
                <div class="row">
                    <div class="col-md-8">
                        <h3>{{ __('Последние статьи') }}</h3>
                        <div class="post-entry-sidebar">
                            <ul>
                                @foreach ($latestArticles as $article)
                                    <li>
                                        <a href="{{ route('article.show', [app()->getLocale(), $article->category->slug, $article->slug]) }}">
                                            <img src="/uploads/{{ $article->preview_image }}" alt="{{ $article->title }}" class="mr-4">
                                            <div class="text">
                                                <h4>{{ $article->title }}</h4>
                                                <div class="post-meta">
                                                    <span class="mr-2">{{ $article->formated_published_at }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="mb-5">
                            <h3>{{ __('Быстрые ссылки') }}</h3>
                            <ul class="list-unstyled">
                                <li><a href="{{ asset('category.article', 'razrabotka-saitov') }}">{{ __('Разработка сайтов') }}</a>
                                </li>
                                <li><a href="{{ asset('category.index') }}">{{ __('Категории') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
