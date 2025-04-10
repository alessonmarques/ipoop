<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restroom;
use Illuminate\Http\Request;

class RestroomController extends Controller
{
    public function nearby(Request $request)
    {
        $type = $request->query('type');
        $accessible = $request->query('accessible');

        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->query('radius', 30); // km

        $restrooms = Restroom::with(['photos', 'reviews.user'])
            ->selectRaw("*,
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )) AS distance", [$lat, $lng, $lat])
            ->having("distance", "<=", $radius)
            ->where('approved', true)
            ->when(in_array($type, ['public', 'private']), fn($q) => $q->where('type', $type))
            ->when($accessible == '1', fn($q) => $q->where('accessible', true))
            ->orderBy("distance")
            ->get();

        return response()->json($restrooms->map(function ($restroom) {
            return [
                'lat' => (float) $restroom->latitude,
                'lng' => (float) $restroom->longitude,
                'title' => $restroom->name,
                'rating' => round($restroom->reviews()->avg('rating')) ?? 0,
                'comment' => $restroom->description,
                'imageUrls' => $restroom->photos->map(fn($photo) => asset('storage/' . $photo->path)),
                'comments' => $restroom->reviews->map(function ($review) {
                    return [
                        'comment' => $review->comment,
                        'rating' => $review->rating,
                        'user' => $review->user
                            ? substr($review->user->name, 0, 2) . '***'
                            : 'Anônimo',
                    ];
                }),
                'detailsUrl' => route('restrooms.show', $restroom),
                'cost' => $restroom->cost,
                'isPublic' => $restroom->type === 'public' ? 1 : 0,
                'isAccessible' => $restroom->accessible ? 1 : 0,
            ];
        }));

    }
}
