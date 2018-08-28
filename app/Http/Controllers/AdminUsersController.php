<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('custom.auth', ['except' => ['user_settings', 'update']]);
    }
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name'      => 'required|unique:users|max:20',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:6',
            'role_id'   => 'required'
        ]);
        $input = $request->all(); 
        $input['password'] = bcrypt($request->password);
        User::create($input);
        
        return redirect('/admin/users')->withInfo('The user has been created');
    }
    public function create()
    {
        return view('admin.users.create');    
    }
	public function index()
	{
		$users = User::orderBy('created_at', 'desc')->paginate(10);
		return view('admin.users.index', compact('users'));
	}
    public function edit(User $user)
    {
    	$roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    public function destroy($id)
    {
        if ($id == 1) {
            return redirect('/admin')->withError('Cannot delete SuperAdmin');
        }
        $user = User::findOrFail($id);
        
        // innoDB cascade is not working, so replies, comments, posts are deleted using eloquent with the code below
        
        // //get all posts of users and delete
        // $postsDelete = $user->posts();
        // $posts = $user->posts()->get();
        // foreach($posts as $post) {
        //     //get all comments of each post and delete
        //     $postId = $post->id;
        //     $post = Post::findOrFail($postId);
        //     $postCommentsDelete = $post->comments();
        //     $postComments = $post->comments()->get();
        //     foreach($postComments as $postComment) {
        //         //get all replies of each comment and delete
        //         $postCommentId = $postComment->id;
        //         $comment = Comment::findOrFail($postCommentId);
        //         $commentRepliesDelete = $comment->replies();
        //         $commentRepliesDelete->delete();
        //     }
        //     $postCommentsDelete->delete();
        // }
        // $postsDelete->delete();
        
        $user->delete();

        return redirect('/admin/users')->withInfo('User deleted');
    }
    // public function destroy_self($id)
    // {
    //     $user = User::findOrFail($id);
    //     auth()->user()->whereId($id)->first()->delete();
    //     return redirect('/')->withInfo('See you around!');
    // }
   	public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name'      => 'required|max:20',
            'email'     => 'required',
        ]);
        $user = User::findOrFail($id);
        if ($request->name !== $user->name) {
            $this->validate(request(), [
                'name' => 'unique:users'
            ]);
            $user->name = $request->name;
        }
        if ($request->email !== $user->email) {
            $this->validate(request(), [
                'email' => 'unique:users'
            ]);
            $user->email = $request->email;
        }
        $user->role_id = $request->role_id;
        $user->verified = $request->verified;
        // ensures no verification token if verified and vice versa //
        if ($user->verified) {
            if ($user->verificationToken) {
                $user->verificationToken->delete();
            } 
        } else {
            if (!$user->verificationToken) {
                $user->verificationToken()->create(['token' => bin2hex(random_bytes(64))]);
            }
        }
        
        //////////////////////////////////////////////////////////////
        if($request->password) {
        	$user->password = bcrypt($request->password);
        }
        
        $user->update();
        
        return redirect('/admin/users')->withInfo('User has been updated');
    }      
    public function user_settings(User $user)
    {
        return view('admin.settings.user', compact('user'));
    }
}