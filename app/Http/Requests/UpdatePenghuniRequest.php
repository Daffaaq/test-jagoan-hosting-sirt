<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenghuniRequest extends FormRequest
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
        return [
            'nama_lengkap'     => 'required|string|max:100',
            'foto_ktp'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_penghuni'  => 'required|in:kontrak,tetap',
            'nomor_telepon'    => 'required|string|max:20',
            'status_menikah'   => 'required|in:menikah,belum menikah',
        ];
    }
}
