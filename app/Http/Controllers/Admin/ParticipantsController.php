<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    CONST TICKET_BATCHES = [
        '1º Lote' => '1º Lote',
        '2º Lote' => '2º Lote',
        '3º Lote' => '3º Lote',
        'CCO' => 'CCO',
    ];

    CONST PAYMENT_FORMS = [
        'pix' => 'PIX',
        'credit_card' => 'Cartão de Crédito'
    ];

    public function index()
    {
        $participants = User::participants()->orderBy('name')->paginate(10);

        return view('admin.participants.index', compact('participants'));
    }

    public function confirmSubscription(User $participant)
    {
        $ticket_batches = self::TICKET_BATCHES;
        $payment_forms = self::PAYMENT_FORMS;
        $subscription = $participant->subscription;

        return view(
            'admin.participants.confirm_subscription',
            compact(
                'ticket_batches',
                'payment_forms',
                'subscription',
                'participant',
            )
        );
    }
}
