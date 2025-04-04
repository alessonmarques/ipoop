<?php

namespace App\Http\Controllers;

use App\Models\Restroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestroomController extends Controller
{
    public function create()
    {
        return view('ipoop.restrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private',
            'accessible' => 'boolean',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cost' => 'nullable|numeric',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['approved'] = false;

        Restroom::create($validated);

        return redirect()->route('home')->with('success', 'Banheiro enviado para revisão.');
    }
}