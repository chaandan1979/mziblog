<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class PostController extends Controller
{
   public function all_post(){
       $posts = Post::with('user','category')->orderByDesc('id')->get();
       return response()->json([
           'posts' => $posts
       ], 200);
    }
    public function save_post(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|min:3|max:50',
            'description'=>'required|min:3|max:1000'
        ]);

      $strpos = strpos($request->photo, ";");
      $sub = substr($request->photo,0,$strpos);
      $ex = explode("/",$sub)[1];
      $imageName = time().".".$ex;
      $img = Image::make($request->photo)->resize(200,300);
      $uploadPath = public_path()."/uploadPostImages/";
      $img->save($uploadPath.$imageName);
      $post = new Post();
      $post->title = $request->title;
      $post->description = $request->description;
      $post->cat_id = $request->cat_id;
      $post->user_id = Auth::user()->id;
      $post->photo = $imageName;
      $post->save();
    }
}
