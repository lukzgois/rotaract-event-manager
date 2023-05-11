<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function confirm(Subscription $subscription, Request $request)
    {
        if ($subscription->isPaid()) {
            return redirect()->route('participants.index')->with('error', 'A inscrição já está confirmada!');
        }
    }
}
