<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        // アクションに合わせたpolicyのメソッドで認可されていないユーザーはエラーを投げる
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Postのデータを用意
        $post = new Post($request->all());
        $post->fill($request->all());
        // ユーザーIDを自分の物にする
        $post->user_id = $request->user()->id;
        // ファイルの用意
        $files = $request->file('file');
        $paths = [];

        // トランザクション開始
        DB::beginTransaction();
        try {
            // Post保存
            $post->save();

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $path = Storage::putFile('posts', $file);
                $paths[] = $path;
                if (!$path) {
                    throw new \Exception("保存に失敗しました");
                }
                $photo = new Photo;
                $photo->post_id = $post->id;
                $photo->img_path = $file_name;
                $photo->name = basename($path);
                $photo->save();
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            if (!empty($paths)) {
                foreach ($paths as $path) {
                    Storage::delete($path);
                }
            }
            // トランザクション終了(失敗)
            DB::rollback();
            return back()
                ->withErrors($e->getMessage());
        }
        return redirect()
            ->route('posts.index')
            ->with(['flash_message' => '登録が完了しました']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Photo $photo)
    {
        return view('posts.edit', compact('post', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->fill($request->all());
        try {
            $post->save();
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('posts.show', $post)->with(['flash_message' => '更新に成功しました']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $images = $post->photo;
        $post->delete();
        foreach ($images as $image) {
            Storage::delete('posts/' . $image->name);
        }
        return redirect()
            ->route('posts.index')
            ->with(['flash_message' => '記事を削除しました']);
    }
}
