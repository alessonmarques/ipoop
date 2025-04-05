<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'restroom'])
                    ->latest()
                    ->paginate(15);

        return view('ipoop.admin.reports.index', compact('reports'));
    }
}