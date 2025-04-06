<?php

namespace App\Http\Controllers;

use App\Models\Restroom;
use App\Models\Review;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $restroomCount = Restroom::count();
        $reviewCount = Review::count();
        $userCount = User::count();

        $testimonials = Review::with('restroom.photos')
            ->whereHas('restroom', function ($query) {
                $query->where('approved', true);
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

    return view('home', compact('restroomCount', 'reviewCount', 'userCount', 'testimonials'));
    }
}
