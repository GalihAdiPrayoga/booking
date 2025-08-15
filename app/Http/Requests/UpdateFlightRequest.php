<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $flightId = $this->route('flight')?->id ?? null;
        return [
            'airline' => 'required|string|max:100',
            'flight_number' => 'sometimes|required|string|max:10|unique:flights,flight_number,' . $flightId,
            'origin_airport_id' => 'required|exists:airports,id|different:destination_airport_id',
            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'classes' => 'required|array|min:1',
            'classes.*.id' => 'required|exists:flights_classes,id',
            'classes.*.price' => 'required|numeric|min:0',
            'classes.*.available_seats' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'flight_number.required' => 'Nomor penerbangan wajib diisi.',
            'flight_number.unique' => 'Nomor penerbangan sudah digunakan.',
            'origin_airport_id.required' => 'Bandara asal wajib diisi.',
            'origin_airport_id.exists' => 'Bandara asal tidak ditemukan.',
            'origin_airport_id.different' => 'Bandara asal tidak boleh sama dengan bandara tujuan.',
            'destination_airport_id.required' => 'Bandara tujuan wajib diisi.',
            'destination_airport_id.exists' => 'Bandara tujuan tidak ditemukan.',
            'destination_airport_id.different' => 'Bandara tujuan tidak boleh sama dengan bandara asal.',
            'departure_time.required' => 'Waktu keberangkatan wajib diisi.',
            'departure_time.date' => 'Format waktu keberangkatan tidak valid.',
            'departure_time.after' => 'Waktu keberangkatan harus setelah waktu sekarang.',
            'arrival_time.required' => 'Waktu kedatangan wajib diisi.',
            'arrival_time.date' => 'Format waktu kedatangan tidak valid.',
            'arrival_time.after' => 'Waktu kedatangan harus setelah waktu keberangkatan.',
            'classes.required' => 'Data kelas penerbangan wajib diisi.',
            'classes.array' => 'Format kelas penerbangan tidak valid.',
            'classes.min' => 'Minimal harus ada 1 kelas penerbangan.',
            'classes.*.id.required' => 'ID kelas penerbangan wajib diisi.',
            'classes.*.id.exists' => 'Kelas penerbangan tidak ditemukan.',
            'classes.*.price.required' => 'Harga kelas penerbangan wajib diisi.',
            'classes.*.price.numeric' => 'Harga harus berupa angka.',
            'classes.*.price.min' => 'Harga tidak boleh kurang dari 0.',
            'classes.*.available_seats.required' => 'Jumlah kursi tersedia wajib diisi.',
            'classes.*.available_seats.integer' => 'Jumlah kursi harus berupa angka bulat.',
            'classes.*.available_seats.min' => 'Jumlah kursi tidak boleh kurang dari 0.'
        ];
    }
}
