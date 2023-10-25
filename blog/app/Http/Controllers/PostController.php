<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            "posts" => Post::all(),
            "categories" => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("posts.create",[
            "categories" => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'text' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'numeric|integer|exists:categories,id',
            'cover_image' => 'file|mimes:jpg,png|max:4096',
        ]);
        $filename = '';
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $filename = 'cover_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put(
                $filename,$file->get()
            );
        }
        $post = Post::factory()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'text' => $validated['text'],
            'cover_image_path' => $filename,
        ]);
        isset($validated['categories']) ? $post->categories()->sync($validated['categories']) : '';
        //dd($validated['categories']);
        Session::flash('post_created');
        return redirect()->route('posts.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
