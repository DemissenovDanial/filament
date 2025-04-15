<div class="col-md-12 col-lg-4 sidebar">
    <!-- END sidebar-box -->
    <div class="sidebar-box">
        <h3 class="heading">{{ __('Последние статьи') }}</h3>
        <div class="post-entry-sidebar">
            <ul>
                <li>
                    @foreach ($latestArticles as $article)
                        <a
                            href="{{ route('article.show', [app()->getLocale(), $article->category->slug, $article->slug]) }}">
                            <img src="/uploads/{{ $article->preview_image }}" alt="{{ $article->title }}" class="mr-4">
                            <div class="text">
                                <h4>{{ $article->title }}</h4>
                                <div class="post-meta">
                                    <span class="mr-2">{{ $article->formated_published_at }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">{{ __('Категории') }}</h3>
        <ul class="categories">
            @foreach ($categories as $category)
                <li><a
                        href="{{ route('article.category', [app()->getLocale(), $category->slug]) }}">{{ $category->title }}<span>({{ $category->articles_count }})</span></a>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">{{ __('Теги') }}</h3>
        <ul class="tags">
            @foreach ($articleTags as $tag)
                @if ($tag)
                    <li><a href="{{ route('article.tag', [app()->getLocale(), $tag]) }}">{{ $tag }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
