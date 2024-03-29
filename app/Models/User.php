<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Club;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    CONST ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'birth_date',
        'phone',
        'club_id',
        'address',
        'city',
        'state',
        'zip_code',
        'is_guest',
        'blood_type',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergies',
        'food_restrictions',
        'rg',
        'cpf',
        'agreed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include popular users.
     */
    public function scopeParticipants(Builder $query): void
    {
        $query->where('user_type', 'participant');
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the subscription associated with the user.
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function isAdmin()
    {
        return $this->user_type == self::ADMIN;
    }
}
