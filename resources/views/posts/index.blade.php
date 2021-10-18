@extends('layouts.app')
@section('title', '一覧画面')
@section('content')
    {{-- {{ dd($photos) }} --}}
    {{-- {{ dd($posts) }} --}}
    <h1>画像一覧</h1>
    <section class="row position-relative" data-masonry='{ "percentPosition": true }'>
        @foreach ($posts as $post)
            <div class="col-6 col-md-4 col-lg-3 col-sl-2 mb-4">
                <article class="card position-relative">
                    <img src="{{ $post->image_url }}" alt="画像" class="card-img-top">
                    <div class="card-title mx-3">
                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none stretched-link">
                            {{ $post->title }}
                        </a>
                    </div>
                </article>
            </div>
        @endforeach
    </section>
    <a href="{{ route('posts.create') }}" class="position-fixed fs-1 bottom-right-50">
        <i class="fas fa-plus-square"></i>
    </a>
@endsection
