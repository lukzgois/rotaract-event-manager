<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'double',
    ];

    /**
     * Get the user that owns the Subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return (bool)!$this->paid_at;
    }

    public function isPaid()
    {
        return (bool)$this->paid_at;
    }

    /**
     * Confirms the subscription
     */
    public function confirm($request)
    {
        $this->paid_at = Carbon::now();
        $this->value = $request->value;
        $this->ticket_batch = $request->ticket_batch;

        $this->save();
    }

    public static function totalPerClub()
    {
        return self::select(DB::raw('
                clubs.name,
                count(subscriptions.id) as total,
                count(subscriptions.id) FILTER (WHERE subscriptions.paid_at IS NULL) as pending,
                count(subscriptions.id) FILTER (WHERE subscriptions.paid_at IS NOT NULL) as paid
            '))
            ->join('users', 'users.id', '=', 'subscriptions.user_id')
            ->join('clubs', 'clubs.id', '=', 'users.club_id')
            ->groupBy('clubs.name')
            ->orderBy('clubs.name')
            ->get();
    }
}
