<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules;
use App\Enums\BloodType;
use App\Enums\BrazilianState;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => preg_replace('/\D/', '', $this->phone), // removing any non digits chars
            'emergency_contact_phone' => preg_replace('/\D/', '', $this->emergency_contact_phone), // removing any non digits chars
            'zip_code' => preg_replace('/\D/', '', $this->zip_code), // removing any non digits chars
        ]);
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
            'phone' => ['required', 'min:10', 'max:11'],
            'club_id' => ['required', 'integer', 'exists:clubs,id'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new Enum(BrazilianState::class)],
            'zip_code' => ['required', 'size:8'],
            'is_guest' => ['required', 'boolean'],
            'blood_type' => ['required', new Enum(BloodType::class)],
            'emergency_contact_name' => ['required'],
            'emergency_contact_phone' => ['required', 'min:10', 'max:11'],
            'rg' => ['required'],
            'cpf' => ['required', 'cpf'],
            'agreed' => ['required', 'accepted'],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->merge(['password' => Hash::make($this->password)]);
    }
}
