<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReportsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $remaining_days = Carbon::now()->diffInDays(Carbon::parse(config('general.event_date')));
        $subscription = Auth::user()->subscription;
        $qrcode = 'resources/images/' . config('payment.qrcode');

        return view('dashboard', compact('remaining_days', 'subscription', 'qrcode'));
    }

    public function admin()
    {
        $participants = User::participants()->count();

        $confirmed = User::participants()->whereHas('subscription', function (Builder $query) {
            $query->whereNotNull('paid_at');
        })->count();

        $pending = User::participants()->whereHas('subscription', function (Builder $query) {
            $query->whereNull('paid_at');
        })->count();

        $subscriptions_per_club = ReportsService::subscriptionsPerClub();

        return view('admin.dashboard', compact(
            'participants',
            'confirmed',
            'pending',
            'subscriptions_per_club',
        ));
    }
}
