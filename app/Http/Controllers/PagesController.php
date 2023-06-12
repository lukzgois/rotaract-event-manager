<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function participants()
    {
        $participants = Club::join('users', 'clubs.id', '=', 'users.club_id')
            ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->orderBy('clubs.name')
            ->orderBy('users.name')
            ->select('users.name', 'clubs.name as club_name')
            ->whereNotNull('subscriptions.paid_at')
            ->get();

        return view('participants', compact('participants'));
    }
}
