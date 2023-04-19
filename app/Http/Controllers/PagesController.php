<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function participants()
    {
        $participants = Club::join('users', 'clubs.id', '=', 'users.club_id')
            ->orderBy('clubs.name')
            ->orderBy('users.name')
            ->select('users.name', 'users.nickname', 'clubs.name as club_name')
            ->where('users.user_type', "=", "participant")
            ->get();

        return view('participants', compact('participants'));
    }
}
