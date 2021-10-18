{{-- {{ dd($photo) }} --}}
@extends('layouts.app')
@section('title', '詳細画面')
@section('content')
    <h1>画像詳細</h1>
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
@endsection
