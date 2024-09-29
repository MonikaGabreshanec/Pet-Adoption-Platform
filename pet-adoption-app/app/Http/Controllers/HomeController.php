<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Donation;
use App\Models\Pets;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function mainPage()
    {
        $pets = Pets::where('adopted', null)->latest()->take(4)->get();
        $posts = Blog::with('user')->latest()->get();
        $donationsCount = Donation::count();
        $adopted= Pets::where('adopted', true)->count();
        return Inertia::render('MainPage', [
            'pets' => $pets,
            'posts' => $posts,
            'donationsCount' => $donationsCount,
            'adopted' => $adopted,
        ]);
    }
}
