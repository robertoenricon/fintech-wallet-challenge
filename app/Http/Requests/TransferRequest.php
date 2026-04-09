<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'value' => ['required', 'numeric', 'gt:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O e-mail do destinatário é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.exists' => 'O destinatário informado não foi encontrado.',
            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser numérico.',
            'value.gt' => 'O valor deve ser maior que zero.',
        ];
    }
}