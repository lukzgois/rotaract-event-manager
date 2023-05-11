<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscription\ConfirmRequest;
use App\Mail\SubscriptionConfirmed;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function confirm(Subscription $subscription, ConfirmRequest $request)
    {
        if ($subscription->isPaid()) {
            return redirect()->route('participants.index')->with('error', 'A inscrição já está confirmada!');
        }

        $subscription->confirm($request->safe());
        Mail::to($subscription->user)->send(new SubscriptionConfirmed($subscription));

        return redirect()->route('participants.index')->with('success', 'A inscrição foi confirmada com sucesso!');
    }
}
