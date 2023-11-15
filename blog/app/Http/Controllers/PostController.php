<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', [
            "users" => User::all(),
            "posts" => Post::paginate(3),
            "categories" => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //if(! Gate::allows('user-id-is-one')) {
        //    abort(403);
        //}
        return view("posts.create", [
            "categories" => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('posts');
        }
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'text' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'numeric|integer|exists:categories,id',
            'cover_image' => 'file|mimes:jpg,png|max:4096',
        ]);
        $filename = '';
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put(
                $filename, $file->get()
            );
        }
        $post = Post::factory()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'text' => $validated['text'],
            'cover_image_path' => $filename,
            'author_id' => $request->user()->id,
        ]);
        isset($validated['categories']) ? $post->categories()->sync($validated['categories']) : '';
        //dd($validated['categories']);
        Session::flash('post_created');
        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'text' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'numeric|integer|exists:categories,id',
            'cover_image' => 'file|mimes:jpg,png|max:4096',
            'remove_cover_image' => 'nullable|numeric',
        ]);
        $cover_image_path = $post->cover_image_path;
        if (isset($validated['remove_cover_image'])) {
            $cover_image_path = null;
            if ($post->cover_image_path != null) {
                Storage::disk('public')->delete($post->cover_image_path);
            }
        } elseif ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put(
                $cover_image_path, $file->get()
            );
        }
        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->text = $validated['text'];
        $post->cover_image_path = $cover_image_path;
        $post->save();

        isset($validated['categories']) ? $post->categories()->sync($validated['categories']) : '';
        //dd($validated['categories']);
        Session::flash('post_edited');
        return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
