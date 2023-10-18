<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use \App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'style' => [
                'required',
                Rule::in(\App\Models\Category::$styles),
            ],
            'name' => 'required|min:3',
        ],[
            'name.required' => 'A név kötelező!',
            'required' => 'A megadott mező kötelező',
            'name.min' => 'A név mező legyen legalább 3 karakter!'
        ]);
        \App\Models\Category::factory()->create($validated);
        Session::flash('category_created');
        Session::flash('name',$validated['name']);
        Session::flash('style',$validated['style']);
        return redirect()->route('categories.create');
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
