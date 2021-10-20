@extends('layouts.app')
@section('title', '詳細画面')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    <h1>画像詳細</h1>
    {{-- {{ dd($post) }} --}}
    <section>
        <article class="card shadow">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $post->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <h1>
                                {{ $post->title }}
                            </h1>
                            <h3>
                                {{ $post->body }}
                            </h3>
                        </figcaption>
                    </div>
                </div>
            </figure>
        </article>
    </section>
    <form action="{{ route('posts.destroy', $post) }}" method="post" id="form">
        @csrf
        @method('delete')
    </form>
    <div class="d-grid col-6 mx-auto gap-3">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        <input type="submit" value="削除" form="form" class="btn btn-danger btn-lg"
            onclick="if (!confirm('本当に削除してよろしいですか？')) {return false};">
    @endsection
