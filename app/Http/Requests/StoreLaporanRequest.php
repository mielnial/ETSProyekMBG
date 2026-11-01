<?php

namespace App\Http\Requests;

use App\Models\Laporan;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'sekolah_id' => ['required', 'integer', 'exists:sekolah,id'],
            'distribusi_id' => [
                'required',
                'integer',
                Rule::exists('distribusi', 'id')
                    ->where(fn ($query) => $query->where('sekolah_id', $this->input('sekolah_id'))),
            ],
            'waktu_kejadian' => ['required', 'date'],
            'jumlah_terdampak' => ['required', 'integer', 'min:1'],
            'gejala' => ['required', 'string', 'max:2000'],
            'uraian' => ['required', 'string', 'max:5000'],
            'bukti' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}
