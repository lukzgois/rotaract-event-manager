<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $remaining_days = Carbon::now()->diffInDays(Carbon::parse(env('EVENT_DATE')));

        return view('dashboard', compact('remaining_days'));
    }
}
