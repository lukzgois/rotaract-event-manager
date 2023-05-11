<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscription\ConfirmRequest;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function confirm(Subscription $subscription, ConfirmRequest $request)
    {
        if ($subscription->isPaid()) {
            return redirect()->route('participants.index')->with('error', 'A inscrição já está confirmada!');
        }
    }
}
