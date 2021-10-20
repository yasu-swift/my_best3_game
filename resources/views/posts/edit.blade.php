{{-- {{ dd($photo) }} --}}
@extends('layouts.main')
@section('title', '編集画面')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    <section>
        <article class="card shadow mb-3">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $post->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <form action="{{ route('posts.update', $post) }}" method="post" id="form">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="title" class="form-label">イメージの説明を入力してください</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $post->title) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="body" class="form-label">その他情報を入力してください</label>
                                    <textarea name="body" id="body" rows="5"
                                        class="form-control">{{ old('body', $post->body) }}</textarea>
                                </div>
                            </form>
                        </figcaption>
                    </div>
                </div>
            </figure>
        </article>
        <div class="d-grid gap-3 col-6 mx-auto">
            <input type="submit" value="更新" form="form" class="btn btn-success btn-lg">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        </div>
    </section>
@endsection
