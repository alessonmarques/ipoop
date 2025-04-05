<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'restroom'])->latest();

        if ($request->has('resolved')) {
            $query->where('resolved', $request->resolved);
        }

        $reports = $query->paginate(15);

        return view('ipoop.admin.reports.index', compact('reports'));
    }

    public function resolve(Report $report)
    {
        $report->update(['resolved' => true]);
        return redirect()->back()->with('success', 'Denúncia marcada como resolvida.');
    }
}