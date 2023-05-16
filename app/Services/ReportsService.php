<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Support\Facades\DB;

class ReportsService  {
    public static function subscriptionsPerClub()
    {
        return Club::select(DB::raw('
                clubs.name,
                count(subscriptions.id) as total,
                count(subscriptions.id) FILTER (WHERE subscriptions.paid_at IS NULL) as pending,
                count(subscriptions.id) FILTER (WHERE subscriptions.paid_at IS NOT NULL) as paid
            '))
            ->leftJoin('users', 'clubs.id', '=', 'users.club_id')
            ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.user_id')
            ->groupBy('clubs.name')
            ->orderBy('clubs.name')
            ->get();
    }
}
