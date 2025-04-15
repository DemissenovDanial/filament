@extends('layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('personal.comment.update', [app()->getLocale(), $comment->id]) }}" method="POST" class="w-50">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea class="form-control" name="message" cols="30" rows="10">{{ $comment->message }}</textarea>
                            @error('message')
                            <div class="text-danger">{{ __(' Это поле необходимо для заполнения ') }}<br /> {{ $message }} </div>
                            @enderror()
                        </div>
                        <input type="submit" class="btn btn-primary bg-dark" value="Обновить">
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection