<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Restroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestroomController extends Controller
{
    public function create()
    {
        return view('ipoop.restrooms.create');
    }

    public function show(Restroom $restroom)
    {
        return view('ipoop.restrooms.show', compact('restroom'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'type' => 'required|in:public,private',
                'accessible' => 'nullable|boolean',
                'cost' => 'required|numeric|min:0',
            ]);

            // Validate the latitude and longitude
            if (!$request->get('latitude') || !$request->get('longitude')) {
                return back()->withErrors(['error' => 'Localização não informada.'])->withInput();
            }
            $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            // Validate latitude and longitude
            $validated['latitude'] = $request->input('latitude');
            $validated['longitude'] = $request->input('longitude');

            // Check if the restroom is accessible
            $validated['accessible'] = in_array($request->input('accessible'), ['on', '1', 1, true], true) ? true : false;

            $validated['user_id'] = Auth::id();
            $validated['approved'] = false;

            // Create a new restroom
            $restroom = Restroom::create($validated);

            // Handle the photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('photos', 'public');
                    Photo::create([
                        'restroom_id' => $restroom->id,
                        'path' => $path,
                    ]);
                }
            }

            return redirect()->route('home')->with('success', 'Banheiro enviado para revisão.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}