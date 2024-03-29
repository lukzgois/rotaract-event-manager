<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Participants\ListRequest;
use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ParticipantsController extends Controller
{
    CONST TICKET_BATCHES = [
        'first_batch' => '1º Lote',
        'second_batch' => '2º Lote',
        'third_batch' => '3º Lote',
        'cco' => 'CCO',
    ];

    CONST PAYMENT_FORMS = [
        'pix' => 'PIX',
        'credit_card' => 'Cartão de Crédito'
    ];

    public function index(ListRequest $request)
    {
        $clubs = ["" => ""] + Club::pluck('name', 'id')->toArray();
        $subscription_status_options = [
            '' => '',
            'confirmed' => 'Confirmadas',
            'pending' => 'Pendentes'
        ];
        $participants = $this->fetchData($request);
        return view('admin.participants.index', compact('participants', 'clubs', 'subscription_status_options'));
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

    private function fetchData($request)
    {
        $participants = User::query();

        if($request->subscription_status == 'confirmed') {
            $participants = $participants->whereHas('subscription', function (Builder $query) {
                $query->whereNotNull('paid_at');
            });
        }

        if($request->subscription_status == 'pending') {
            $participants = $participants->whereHas('subscription', function (Builder $query) {
                $query->whereNull('paid_at');
            });
        }

        if($request->filled('name')) {
            $participants = $participants->where('name', 'ilike', "{$request->name}%");
        }

        if($request->filled('nickname')) {
            $participants = $participants->where('nickname', 'ilike', "{$request->nickname}%");
        }

        if($request->filled('club_id')) {
            $participants = $participants->where('club_id', (int)$request->club_id);
        }

        return $participants->orderBy('name')->paginate(10)->withQueryString();;
    }
}
