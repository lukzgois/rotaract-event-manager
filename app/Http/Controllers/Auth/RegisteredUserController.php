<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Club;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use App\Enums\BloodType;
use App\Enums\BrazilianState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $states = ["" => "Selecione um estado"] + BrazilianState::toOptionsArray();
        $clubs = ["" => "Selecione um clube"] + Club::pluck('name', 'id')->toArray();
        $blood_types = ["" => "Selecione um tipo sanguíneo"] + BloodType::toOptionsArray();

        return view('auth.register', compact('states', 'clubs', 'blood_types'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $user = User::create($request->validated());
            $user->subscription()->create();
            event(new Registered($user));

            Auth::login($user);
        });

        return redirect(RouteServiceProvider::HOME);
    }
}
