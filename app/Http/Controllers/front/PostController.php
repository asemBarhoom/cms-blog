<?php

namespace App\Http\Controllers\front;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        return view('front.post.index',compact('posts' , 'categories'));
    }
}
