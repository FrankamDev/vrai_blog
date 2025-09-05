<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PostController extends Controller
{
    public function create(): Response
    {
      if(!Auth::check()){
        abort(403);
      }
      return Inertia::render("Posts/Create");
    }

    public function store(Request $request)
    {
      if(!Auth::check()){
        abort(403);
      }
      $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'image' => 'nullable|image|mimes:png,jpg,gif,jpeg,svg|max:2048',
      ]);

      $post = new Post();
      $post->title = $validated['title'];
      $post->description = $validated['description'];
      $post->user_id = Auth::id();
// si l'image existe
      if($request->hasFile('image')){
        $path = $request->file('image')->store('posts', 'public');
        $post->image = $path;
      }
      $post->save();
      return redirect()-> route('dashboard')->with('success', 'creee avec succes');
    }

    public function show(Post $post) {
      return Inertia::render('Posts/Show', [
        'post' => $post->load('author')
      ]);
    }
    public function edit(Post $post) {
      return Inertia::render('Posts/Edit', [
        'post' => $post
      ]);
    }

  public function update(Request $request, Post $post)
  {
   
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'image' => 'nullable|image|mimes:png,jpg,gif,jpeg,svg|max:2048',
    ]);

    $post = new Post();
    $post->title = $validated['title'];
    $post->description = $validated['description'];
    $post->user_id = Auth::id();
    // si l'image existe
    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('posts', 'public');
      $post->image = $path;
    }
    $post->save();
    return redirect()->route('dashboard')->with('success', 'creee avec succes');
  }
}
