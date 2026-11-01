<?php

namespace App\Http\Requests;

use App\Models\Laporan;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Laporan::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
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
        ];
    }
}
