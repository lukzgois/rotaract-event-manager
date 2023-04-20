<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    protected $clubs = [
        'Ampére',
        'Capanema',
        'Cascavel Paz',
        'Chopinzinho União',
        'Clevelândia',
        'Coronel Vivida',
        'Dois Vizinhos – Amizade',
        'Foz do Iguaçu M’Boicy',
        'Foz do Iguaçu Terra das Águas',
        'Francisco Beltrão',
        'Francisco Beltrão UTFPR',
        'Guarapuava',
        'Itapejara d’Oeste',
        'Laranjeiras do Sul',
        'Marechal Cândido Rondon',
        'Medianeira',
        'Palmas',
        'Palotina Pioneiro',
        'Pato Branco Amizade – UTFPR',
        'Pato Branco Vila Nova',
        'Pato Branco – Sul',
        'Pitanga Avante',
        'Planalto',
        'Santa Terezinha de Itaipu',
        'São Jorge do Oeste',
        'Toledo',
        'Toledo – Integração',
        'Universitário Medianeira Rio Alegria',
        'Outro',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach($this->clubs as $club) {
            \App\Models\Club::factory()->create(['name' => $club]);
        }

        $clubs = \App\Models\Club::inRandomOrder()->limit(3)->get();

        \App\Models\User::factory(15)
            ->hasSubscription()
            ->sequence(
                ['club_id' => $clubs[0]->id],
                ['club_id' => $clubs[1]->id],
                ['club_id' => $clubs[2]->id],
            )
            ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'pending@test.com',
        ])
        ->hasSubscription()
        ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'paid@test.com',
        ])
        ->hasSubscription(['paid_at' => Carbon::now()])
        ->create();

        \App\Models\User::factory([
            'club_id' => $clubs[0]->id,
            'email' => 'admin@test.com',
            'user_type' => 'admin'
        ])
        ->hasSubscription()
        ->create();
    }
}
