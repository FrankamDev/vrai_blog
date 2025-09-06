<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class WelcomeController extends Controller
{
    public function index(): InertiaResponse
    {
        $posts = Post::with('author')->latest()->get();

        return Inertia::render('welcome', [
            'posts' => $posts,
            'canRegister' => config('services.registration.enabled', true)
        ]);
    }
}
