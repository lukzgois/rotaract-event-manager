<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index()
    {
        $participants = User::participants()->orderBy('name')->paginate(10);

        return view('admin.participants.index', compact('participants'));
    }
}
