@extends('layouts.main')
@section('title', '詳細画面')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    <section>
        <article class="card shadow">
            <figure class="m-3">
                <div class="row">
                    @foreach ($post->photo as $photo)
                        <article class="w-full px-4 md:w-1/4 text-xl text-gray-800 leading-normal">
                            <td><img src="{{ Storage::url('posts/' . $photo->name) }}" width="100%"></td>
                        </article>
                    @endforeach
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
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}">
                    <i class="fas fa-edit position-absolute top-0 end-0 fs-1"></i>
                </a>
            @endcan
        </article>
    </section>
    <form action="{{ route('posts.destroy', $post) }}" method="post" id="form">
        @csrf
        @method('delete')
    </form>
    <div class="d-grid col-6 mx-auto gap-3">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        @can('delete', $post)
            <input type="submit" value="削除" form="form" class="btn btn-danger btn-lg"
                onclick="if (!confirm('本当に削除してよろしいですか？')) {return false};">
        @endcan
    </div>
@endsection
