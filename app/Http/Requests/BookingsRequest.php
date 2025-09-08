<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'booking_date' => 'required|date',
            'passengers' => 'required|array',
            'passengers.*.name' => 'required|string',
            'passengers.*.identity_number' => 'required|string',
            'passengers.*.ticket_id' => 'required|integer|exists:tickets,id',
        ];
    }

    public function messages()
    {
        return [
            'ticket_id.required' => 'Ticket ID harus diisi',
            'ticket_id.integer' => 'Ticket ID harus berupa angka',
            'ticket_id.exists' => 'Ticket tidak ditemukan',
            // Pesan error lainnya...
        ];
    }
}
