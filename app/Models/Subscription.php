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
}
