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
    public function delete_post($id){
       $post = Post::find($id);
       $image_path = public_path()."/uploadPostImages/";
       $image = $image_path.$post->photo;
       if(file_exists($image)){
           @unlink($image);
       }
       $post->delete();
    }
    public function edit_post($id){
        $post = Post::find($id);
        return response()->json([
            'post' => $post
        ], 200);
    }

    public function update_post(Request $request, $id){
        $post = Post::find($id);
        $this->validate($request,[
            'title'=>'required|min:3|max:50',
            'description'=>'required|min:3|max:1000'
        ]);

        if($request->photo != $post->photo){
            $image_path = public_path()."/uploadPostImages/";
            $image = $image_path.$post->photo;
            if(file_exists($image)){
                @unlink($image);
            }
            $strpos = strpos($request->photo, ";");
            $sub = substr($request->photo,0,$strpos);
            $ex = explode("/",$sub)[1];
            $imageName = time().".".$ex;
            $img = Image::make($request->photo)->resize(200,300);
            $uploadPath = public_path()."/uploadPostImages/";
            $img->save($uploadPath.$imageName);
        }else{
            $imageName =  $post->photo;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->cat_id = $request->cat_id;
        $post->user_id = Auth::user()->id;
        $post->photo = $imageName;
        $post->save();
    }
}
