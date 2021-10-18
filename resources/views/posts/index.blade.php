@extends('layouts.app')
@section('title', '一覧画面')
@section('content')
    {{-- {{ dd($photos) }} --}}
    {{-- {{ dd($posts) }} --}}
    <h1>画像一覧</h1>
    <section class="row" data-masonry='{ "percentPosition": true }'>
        @foreach ($posts as $post)
            <div class="col-6 col-md-4 col-lg-3 col-sl-2 mb-4">
                <article class="card">
                    <img src="{{ $post->image_url }}" alt="画像" class="card-img-top">
                    <div class="card-title mx-3">
                        {{ $post->title }}
                    </div>
                </article>
            </div>
        @endforeach
    </section>
@endsection
