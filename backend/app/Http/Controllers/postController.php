<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class postController extends Controller
{
const LOCAL_STORAGE_FOLDER = "public/images/";
private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }
    public function index(){
        // getting all the posts from db
        $all_posts = $this->post->latest()->paginate(5);

        // send the all_posts the index
        return view('posts.index')->with('all_posts',$all_posts);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        $request->validate(
            [
                'title' => 'required|min:1|max:50',
                'body' => 'required|min:1|max:100',
                'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048'
            ]); // mime = multipurpose internet mail extensions
            // save inputs to the database

            $this->post->user_id = Auth::user()->id;
            // will get the id of currently logged in user
            $this->post->title = $request->title;
            $this->post->body = $request->body;
            $this->post->image = $this->saveImage($request);
            $this->post->save(); // save the values to db

            return redirect()->route('index'); // go back to homepage
        }

        public function saveImage($request){
            // changing name of the image to prevent duplcate / overwrite
            $image_name = time() . "." . $request->image->extension();

            // saving the image to strage folder
            $request->image->storeAs(self::LOCAL_STORAGE_FOLDER,$image_name);

            // return the image name to be saved in the database
            return $image_name;
        }

        public function show($id){
            $post = $this->post->findOrFail($id);
            return view('posts.show')
            ->with('post',$post);
        }

        public function edit($id){
            $post = $this->post->findOrFail($id);
            return view('posts.edit')
            ->with('post',$post);

        }

        public function update(Request $request,$id){
            $request->validate(
                [
                    'title' => 'required|min:1|max:50',
                    'body' => 'required|min:1|max:100'

                ]); // mime = multipurpose internet mail extensions

                // will get the record that goin to edit
                $post = $this->post->findOrFail($id);
                $post -> title = $request-> title;
                $post -> body = $request-> body;

                //check ig the user update the image
                if($request->image){

                    $request->validate([
                        'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048'
                    ]);

                    // delete the old image
                    $this->deleteImage($post->image);

                    // save the new image to storage and sabe to db
                    $post->image =$this->saveImage($request);

                }

                // save everything to database
                $post-> save();
                // goint to show post page together with the id as parameter
                return redirect()->route('post.show',$id);
        }

        public function deleteImage($image_name){
            $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;

            if(Storage::disk('local')->exists($image_path)){
                Storage::disk('local')->delete($image_path);
            }
        }

        public function destroy($id){
            // getting the record from the db
            $post = $this->post->findOrFail($id);
            // deleting image from storage
            $this->deleteImage($post->image);
                $image_path = self::LOCAL_STORAGE_FOLDER ;

                if(Storage::disk('local')->exists($image_path)){
                    Storage::disk('local')->delete($image_path);
                }

            // dd($id);
            // instantiate
            // $post_obj = new Post;
            // delete 1 record
            $this->post -> destroy($id);
            //this 2 are the same
            // $this->post_model = $post_obj -> destroy(3,4,1);
            // $id = [3,4,1];
            // $this->post_model_obj-> destroy($id);
            return redirect() -> route('index');
           }

}
