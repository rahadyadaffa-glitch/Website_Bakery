<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_number' => 'required|string|max:10',
            'customer_name' => 'required|string|max:50',
            'notes' => 'nullable|string|max:255',
        ];
    }
    
    public function messages()
    {
        return [
            'table_number.required' => 'Nomor meja wajib diisi.',
            'customer_name.required' => 'Nama wajib diisi biar pelayan tidak tertukar.',
        ];
    }
}
