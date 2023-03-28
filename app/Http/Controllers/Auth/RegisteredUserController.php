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
            'birth_date' => ['required', 'date', 'before_or_equal:2005-06-17'],
            'phone' => ['required', 'celular_com_ddd'],
            'club_id' => ['required', 'integer', 'exists:clubs,id'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new Enum(BrazilianState::class)],
            'zip_code' => ['required'],
            'is_guest' => ['required', 'boolean'],
            'blood_type' => ['required', new Enum(BloodType::class)],
            'emergency_contact_name' => ['required'],
            'emergency_contact_phone' => ['required', 'celular_com_ddd'],
            'rg' => ['required'],
            'cpf' => ['required', 'cpf'],
            'agreed' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
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
