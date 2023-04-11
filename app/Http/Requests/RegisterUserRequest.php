<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules;
use App\Enums\BloodType;
use App\Enums\BrazilianState;
use App\Models\User;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
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
        ];
    }
}
