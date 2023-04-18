<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $remaining_days = Carbon::now()->diffInDays(Carbon::parse(env('EVENT_DATE')));
        $subscription = Auth::user()->subscription;
        $qrcode = 'resources/images/' . config('payment.qrcode');

        return view('dashboard', compact('remaining_days', 'subscription', 'qrcode'));
    }
}
