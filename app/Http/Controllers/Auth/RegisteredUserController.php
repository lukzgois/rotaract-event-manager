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
use Illuminate\Support\Facades\Hash;
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
        $user = User::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'club_id' => $request->club_id,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'is_guest' => $request->is_guest,
            'blood_type' => $request->blood_type,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'allergies' => $request->allergies,
            'food_restrictions' => $request->food_restrictions,
            'rg' => $request->rg,
            'cpf' => $request->cpf,
            'agreed' => $request->agreed,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
