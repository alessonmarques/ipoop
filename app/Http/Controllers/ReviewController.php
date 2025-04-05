<?php

namespace App\Http\Controllers;

use App\Models\Restroom;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Restroom $restroom)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verifica se o usuário já avaliou este banheiro
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('restroom_id', $restroom->id)
                                ->first();

        if ($existingReview) {
            return back()->withErrors(['error' => 'Você já avaliou este banheiro.']);
        }

        Review::create([
            'user_id' => Auth::id(),
            'restroom_id' => $restroom->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return back()->with('success', 'Avaliação enviada com sucesso!');
    }

}