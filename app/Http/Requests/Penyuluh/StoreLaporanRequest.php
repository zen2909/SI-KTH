<?php

namespace App\Http\Requests\Penyuluh;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'penyuluh';
    }

    public function rules(): array
    {
        return [
            // Data Dasar
            'id_kth' => 'required|exists:kth,id',
            'periode_laporan' => 'required|date',
            'jenis_usaha' => 'nullable|string',

            // Legalitas & Branding
            'nib' => 'nullable|string|max:50',
            'pirt' => 'nullable|string|max:50',
            'sertifikat_halal_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'merek_dagang' => 'nullable|string|max:100',

            // Produksi & Ekonomi
            'potensi_produksi' => 'nullable|numeric|min:0',
        'satuan_produksi' => 'nullable|string|in:Kg,Ton,Liter,Unit',
            'nte_per_bulan' => 'nullable|numeric|min:0',
            'jangkauan_pemasaran' => 'nullable|string|max:255',

            // Operasional
            'kendala_usaha' => 'nullable|string',
            'kebutuhan_pengembangan' => 'nullable|string',
            'keterangan_tambahan' => 'nullable|string',

            // Dokumentasi
            'dokumentasi' => 'nullable|array|max:5',
            'dokumentasi.*' => 'file|mimes:jpg,jpeg,png,mp4|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'id_kth.required' => 'Pilih KTH terlebih dahulu.',
            'id_kth.exists' => 'KTH yang dipilih tidak valid.',
            'periode_laporan.required' => 'Periode laporan wajib diisi.',
            'periode_laporan.date' => 'Format periode laporan tidak valid.',
            'sertifikat_halal_file.max' => 'Ukuran file sertifikat maksimal 5MB.',
            'dokumentasi.max' => 'Maksimal upload 5 file dokumentasi.',
            'dokumentasi.*.max' => 'Ukuran file dokumentasi maksimal 10MB.',
        ];
    }
}
