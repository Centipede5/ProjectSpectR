<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

use App\Http\Requests\StorePost as StorePostRequest;
use App\Http\Requests\UpdatePost as UpdatePostRequest;

use Auth;
use Gate;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::published()->paginate();
        return view('demo-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('demo-posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->all();
        $data['slug'] = str_slug($data['post_title']);
        $data['user_id'] = Auth::user()->id;            // Set the user_id of the post to the current logged in user
        $post = Post::create($data);
        return redirect()->route('edit_post', ['id' => $post->id]);
    }

    public function show($id)
    {
        $post = Post::published()->findOrFail($id);
        return view('demo-posts.show', compact('post'));
    }

    public function drafts()
    {
        $postsQuery = Post::unpublished();
        if(Gate::denies('see-all-drafts')) {
            $postsQuery = $postsQuery->where('user_id', Auth::user()->id);
        }
        $posts = $postsQuery->paginate();
        return view('demo-posts.drafts', compact('posts'));
    }

    public function edit(Post $post)
    {
        return view('demo-posts.edit', compact('post'));
    }

    public function update(Post $post, UpdatePostRequest $request)
    {
        $data = $request->only('post_title', 'post_content');
        $data['slug'] = str_slug($data['post_title']);
        $post->fill($data)->save();

        return redirect()->route('list_posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('list_posts');
    }

    public function publish(Post $post)
    {
        $post->published = true;
        $post->save();
        return back();
    }
}
