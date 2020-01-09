<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function get_all_post(){
        $posts = Post::with('user','category')->orderByDesc('id')->get();
        return response()->json([
            'posts' => $posts
        ], 200);
    }
}
