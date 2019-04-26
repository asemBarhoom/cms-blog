<?php


namespace App\Http\Controllers\cPanel;
use App\Http\Controllers\Controller;

use App\Category;
use App\Pic;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the posts
     *
     * @param  \App\Post  $model
     * @return \Illuminate\View\View
     */
    public function index(Post $model)
    {

        return view('posts.index', ['posts' => $model->paginate(15) ]);
    }

    /**
     * Show the form for creating a new Post
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $pics = Pic::all();
        return view('posts.create',['categories'=>$categories , 'pics'=>$pics]);
    }

    /**
     * Store a newly created Post in storage
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Post  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {


        $model = Post::create([
            'user_id'=>Auth::id(),
            'title'=>$request->title,
            'body'=>$request->body,
            'pic_id'=>$request->pic_id,
         ]);

        $model->categories()->sync($request->categories);

        return redirect()->route('post.index')->withStatus(__('Post successfully created.'));
    }

    /**
     * Show the form for editing the specified Post
     *
     * @param  \App\Post  $Post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $pics = Pic::all();
        return view('posts.edit', compact('post','categories' ,'pics'));
    }

    /**
     * Update the specified Post in storage
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Post  $Post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
       $Post = Post::find($id);
        $Post->update([
            'title'=>$request->title,
            'body'=>$request->body,
            'pic_id'=>$request->pic_id,
             ]);
        $Post->categories()->sync($request->categories);

        return redirect()->route('post.index')->withStatus(__('Post successfully updated.'));
    }

    /**
     * Remove the specified Post from storage
     *
     * @param  \App\Post  $Post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post  $Post)
    {
        $Post->delete();

        return redirect()->route('post.index')->withStatus(__('Post successfully deleted.'));
    }
}
