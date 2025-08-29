<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $query = Post::where('user_id', $user_id);

        if ($request->has('search'))
        {
            $search = $request->input('search');
            $query->where(function ($q) use ($search)
            {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }
        $posts = $query->get();

        return response()->json(["ok" => true, "post" => $posts->toResourceCollection(), "user" => $request->user()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:255'],
        ]);
        $data['user_id'] = $request->user()->id;


        $post = Post::create($data);
        return response()->json(["ok" => true, "post" => $post, "user" => $request->user()], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        Gate::authorize('view', $post);
        return response()->json(["ok" => true, "post" => $post, "user" => $request->user()], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:255'],
        ]);
        $post->update($data);
        return response()->json(["ok" => true, "post" => $post, "user" => $request->user()], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return response()->json(["ok" => true, "message" => "Post has been deleted successfully"], 204);
    }
}
