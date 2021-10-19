@extends('layouts.app')
@section('title', '一覧画面')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    {{-- {{ dd($photos) }} --}}
    {{-- {{ dd($posts) }} --}}
    <h1>画像一覧</h1>

    <section class="row position-relative" data-masonry='{ "percentPosition": true }'>
        @foreach ($photos as $photo)
            <div class="col-6 col-md-4 col-lg-3 col-sl-2 mb-4">
                <article class="card position-relative">
                    {{-- {{ dd($photo) }} --}}
                    <img src="{{ $photo->image_url }}" alt="画像" class="card-img-top">
                    <div class="card-title mx-3">
                        <a href="{{ route('posts.show', $photo) }}" class="text-decoration-none stretched-link">
                            {{ $photo->post->title }}
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
