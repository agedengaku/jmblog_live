<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Post;
use App\Photo;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('custom.auth');
    }
    public function store(Request $request)
    {
        if (auth()->user()->role_id === 1 || auth()->user()->role_id === 2) {
            $this->validate(request(), [
            	'title' => 'required|max:100',
                'subheading' => 'max:100',
            	'body' 	=> 'required'
            ]);
            $input = $request->all(); 

            if($file = $request->file('photo')) {
                $name = $file->getClientOriginalName();
                $file->move('photos/shares', $name);
                $photo = Photo::create(['file'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $post = new Post;
            $post->user_id = auth()->user()->id;
            $post->title = $request->title;
            $post->subheading = $request->subheading;
            $post->category_id = $request->category_id;
            $post->body = $request->body;

            if($request->file('photo')){
                $post->photo_id = $input['photo_id'];
            }

            $post->save();
            $post->tags()->sync($request->tags, false);
            // auth()->user()->posts()->create($input);
            // session()->flash('message', 'Your post has now been published');
            return redirect('/admin/posts')->withInfo('Your post has been published');
        } else {
            return redirect('/')->withError('You are not authorized to create posts.');
        }

    }
    public function index() 
    {
        if (auth()->user()->role_id === 1) {
            $posts = Post::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.posts.index', compact('posts'));
        }
        if(auth()->user()->role_id === 2) {
            $userId = auth()->user()->id;
            $posts = Post::where('user_id', '=', $userId)->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.posts.index', compact('posts'));
        }
    }
    public function create()
    {
        if(Category::all()) {
            $categories = Category::pluck('name', 'id')->all();
        } else {
            $categories = array();
        }
        if(Tag::all()) {
            $tags = Tag::all();    
        } else {
            $tags = array();
        }
        return view('admin.posts.create', compact('categories', 'tags'));
    }
    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id')->all();
        $tags = Tag::all();
        $tagArr = array();

        foreach($tags as $tag) {
            $tagArr[$tag->id] = $tag->name;
        }

        return view('admin.posts.edit', compact('post', 'categories', 'tagArr'));
    }    
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'title' => 'required|max:100',
            'subheading' => 'max:100',
            'body'  => 'required'
        ]);
        $input = $request->all(); 

        if($file = $request->file('photo')) {
            $name = $file->getClientOriginalName();
            $file->move('photos/shares', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->subheading = $request->subheading;
        $post->category_id = $request->category_id;
        $post->body = $request->body;

        if($request->file('photo')){
            $post->photo_id = $input['photo_id'];
        }

        $post->update();
        $post->tags()->sync($request->tags);    
        // auth()->user()->posts()->whereId($id)->first()->update($input);
        // session()->flash('message', 'Your post has now been updated');
        return redirect('/admin/posts')->withInfo('Your post has been updated');
    }
    public function confirm_destroy($id) {

    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->photo) {
            unlink(public_path() . "/photos/shares/" . $post->photo->file);
            Photo::findOrFail($post->photo_id)->delete();
        }
        if (auth()->user()->role_id === 1) {
            $post->delete();
        } else {
            auth()->user()->posts()->whereId($id)->first()->delete();
        }
        // return redirect('/admin')->with('status', 'Post deleted');
        return redirect('/admin/posts')->withInfo('Post deleted');
    }   
}