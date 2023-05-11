<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function confirmed()
    {
        return $this->state(fn (array $attributes) => [
            'value' => '180',
            'ticket_batch' => '1 Lote',
            'payment_type' => 'pix',
            'paid_at' => '2023-01-01',
        ]);
    }
}
