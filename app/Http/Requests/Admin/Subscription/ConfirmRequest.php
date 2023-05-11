<?php

namespace App\Http\Requests\Admin\Subscription;

use App\Enums\PaymentType;
use App\Enums\TicketBatch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ConfirmRequest extends FormRequest
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
            'value' => str_replace(',', '.', $this->value),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|decimal:2',
            'ticket_batch' => [
                'required',
                new Enum(TicketBatch::class),
            ],
            'payment_type' => [
                'required',
                new Enum(PaymentType::class),
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payment_type' => 'A forma de pagamento selecionada é inválida.',
        ];
    }
}
