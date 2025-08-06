<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAirportsRequest extends FormRequest
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
     * @return array<string, 
     */
    public function rules(): array
    {
       $airportId = $this->route('airport')->id ?? $this->route('airport');
        return [
            'code' => 'required|string|max:5|unique:airports,code,' . $airportId,
            'name' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode bandara wajib diisi.',
            'code.unique' => 'Kode bandara sudah digunakan.',
            'name.required' => 'Nama bandara wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'country.required' => 'Negara wajib diisi.',
        ];
    }
}
