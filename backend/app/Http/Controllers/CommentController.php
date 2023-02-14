<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store($post_id, Request $request){
        // yalidate the comment
        $request->validate([
            'comment' => 'required|min:1|max:150'
        ]);

        $this->comment->user_id = Auth::user()->id; // currently logged user
        $this->comment->post_id = $post_id; // post that user commented
        $this->comment->body = $request->comment; //comment from input
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id){
        // getting the record from the db
        $comment = $this->comment->findOrFail($id);
        // deleting image from storage

        // dd($id);
        // instantiate
        // $post_obj = new Post;
        // delete 1 record
        $this->comment -> destroy($id);
        // this 2 are the same
        // $this->post_model = $post_obj -> destroy(3,4,1);
        // $id = [3,4,1];
        // $this->post_model_obj-> destroy($id);
        return redirect() -> back();
       }
       public function update($id,Request $request){
        $comment = $this->comment->findOrFail($id);
        $comment->body = $request->comment;
        $comment->save();

        return redirect()->back();
       }

}
