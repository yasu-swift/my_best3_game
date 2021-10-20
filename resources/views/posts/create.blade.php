@extends('layouts.app')
@section('title', '新規登録')
@section('content')
    <div class="col-8 col-offset-2 mx-auto">
        {{-- @include('partial.flash')
        @include('partial.errors') --}}
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            <div class="card mb-3">
                @csrf

                <div class="row m-3">
                    <div class="mb-3">
                        <label for="file" class="form-label">画像ファイルを選択してください</label>
                        <input type="file" name="file" id="file" class="form-control" value="{{ old('file') }}">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">説明を入力してください</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    </div>
                    <div>

                        <label for="body" class="form-label">説明を入力してください</label>
                        <textarea name="body" id="body" rows="5" class="form-control">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>
            <input type="submit">
        </form>
    </div>
@endsection
