@extends('layouts.main')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

@section('content')
    <!-- Content Wrapper. Contains page content -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['articleUserLikesCount'] }}</h3>
                                <p>{{ __('Понравившиеся статьи') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-heart"></i>
                            </div>
                            <a href="{{ route('liked', [app()->getLocale()]) }}" class="small-box-footer">{{ __('Подробнее') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['articleUserCommentsCount'] }}</h3>
                                <p>{{ __('Комментарии') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-comment"></i>
                            </div>
                            <a href="{{ route('comment', [app()->getLocale()]) }}" class="small-box-footer">{{ __('Подробнее') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </section>
@endsection
