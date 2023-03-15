<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\BloodType;
use App\Enums\BrazilianState;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birth_date' => ['required', 'date', 'after_or_equal:2005-06-17'],
            'phone' => ['required'],
            'club_id' => ['required', 'integer', 'exists:clubs,id'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new Enum(BrazilianState::class)],
            'zip_code' => ['required'],
            'is_guest' => ['required', 'boolean'],
            'blood_type' => ['required', new Enum(BloodType::class)],
            'emergency_contact_name' => ['required'],
            'emergency_contact_phone' => ['required'],
            'allergies' => ['required'],
            'food_restrictions' => ['required'],
            'rg' => ['required'],
            'cpf' => ['required'],
            'agreed' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
