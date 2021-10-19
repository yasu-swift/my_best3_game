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
                        {{-- {{ dd($post->photo->first->name->name) }} --}}
                        {{-- <img src="{{ Storage::url('posts/' . App\Models\Photo::where('post_id', $post->id)->first()->name) }}"> --}}
                        {{-- <img src="{{ Storage::url('posts/' . $post->photo->first->name->name) }}"> --}}
                        {{-- <img src="{{ Storage::url($post->image_path) }}"> --}}
                        {{-- <img src="{{ Storage::url('posts/' . $post->photo->name) }}" width="100%"> --}}
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
