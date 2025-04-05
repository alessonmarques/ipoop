<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restroom_id' => 'required|exists:restrooms,id',
            'reason' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'restroom_id' => $validated['restroom_id'],
            'reason' => $validated['reason'],
        ]);

        return redirect()->back()->with('success', 'Obrigado por sua denúncia! Ela será analisada.');
    }
}