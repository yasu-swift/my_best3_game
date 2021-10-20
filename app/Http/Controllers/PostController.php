<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
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
        $photos = Photo::all();
        return view('posts.index', compact('photos'));
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
        // ユーザーIDを自分の物にする
        $post->user_id = $request->user()->id;
        // ファイルの用意
        $file = $request->file('file');

        // トランザクション開始
        DB::beginTransaction();
        try {

            // Post保存
            $post->save();

            // 画像ファイル保存
            if (!$path = Storage::putFile('posts', $file)) {
                throw new Exception('ファイルの保存に失敗しました');
            }
            // Photoモデルの情報を用意
            $photo = new Photo([
                'post_id' => $post->id,
                'img_path' => $file->getClientOriginalName(),
                'name' => basename($path),
            ]);
            // dd($photo);
            // Photo保存
            $photo->save();
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            if (!empty($path)) {
                Storage::delete($path);
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
        $photos = Photo::all();
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
        // $pathに仮置しておく
        $path = $post->image_path;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // post削除すればphotoも削除される
            $post->delete();
            // 画像削除
            if (!Storage::delete($path)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの削除に失敗しました。');
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
        return redirect()
            ->route('posts.index')
            ->with('notice', '記事を削除しました');
    }
}
