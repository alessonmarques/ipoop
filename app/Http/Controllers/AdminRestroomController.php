<?php

namespace App\Http\Controllers;

use App\Models\Restroom;
use Illuminate\Http\Request;

class AdminRestroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Restroom::with('user');

        if ($request->has('approved')) {
            $query->where('approved', $request->boolean('approved'));
        }

        $restrooms = $query->latest()->paginate(10);

        return view('ipoop.admin.restrooms.index', compact('restrooms'));
    }

    public function show(Restroom $restroom)
    {
        return view('ipoop.admin.restrooms.show', compact('restroom'));
    }

    public function approve(Restroom $restroom)
    {
        $restroom->approved = true;
        $restroom->save();

        return redirect()->back()->with('success', 'Banheiro aprovado com sucesso.');
    }

    public function destroy(Restroom $restroom)
    {
        $restroom->delete();

        return redirect()->back()->with('success', 'Banheiro excluído.');
    }
}