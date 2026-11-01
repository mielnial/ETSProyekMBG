<?php

namespace App\Http\Requests;

use App\Models\Laporan;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $laporan = $this->route('laporan');

        return $user !== null
            && $laporan instanceof Laporan
            && $user->can('update', $laporan);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'distribusi_id' => ['required', 'integer', 'exists:distribusi,id'],
            'waktu_kejadian' => ['required', 'date'],
            'jumlah_terdampak' => ['required', 'integer', 'min:1'],
            'gejala' => ['required', 'string', 'max:2000'],
            'uraian' => ['required', 'string', 'max:5000'],
            'bukti' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}
