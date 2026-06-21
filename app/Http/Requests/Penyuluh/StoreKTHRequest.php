<?php

namespace App\Http\Requests\Penyuluh;

use Illuminate\Foundation\Http\FormRequest;

class StoreKTHRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'penyuluh';
    }

    public function rules(): array
    {
        return [
            // Identitas Kelompok - SEMUA WAJIB
            'nama_kth' => 'required|string|max:255|unique:kth,nama_kth',
            'kelas_kth' => 'required|string|in:Pemula,Madya,Utama',
            'nomor_register' => 'required|string|max:100|unique:kth,nomor_register',
            'tanggal_register' => 'required|date',

            // Lokasi & Kontak - SEMUA WAJIB
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'nama_ketua' => 'required|string|max:255',
            'no_hp_ketua' => 'required|string|max:20',

            // Lokasi Geografis - WAJIB
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Status - WAJIB
            'status_kth' => 'required|in:Aktif,Tidak Aktif',

            // Tahun tidak aktif - WAJIB JIKA status = Tidak Aktif (divalidasi di withValidator)
            'tahun_tidak_aktif' => 'nullable|integer|min:2000|max:'.date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            // Identitas
            'nama_kth.required' => 'Nama KTH wajib diisi.',
            'nama_kth.unique' => 'Nama KTH sudah terdaftar, gunakan nama lain.',
            'kelas_kth.required' => 'Kelas KTH wajib dipilih.',
            'kelas_kth.in' => 'Kelas KTH harus: Pemula, Madya, atau Utama.',
            'nomor_register.required' => 'Nomor register wajib diisi.',
            'nomor_register.unique' => 'Nomor register sudah digunakan.',
            'tanggal_register.required' => 'Tanggal register wajib diisi.',

            // Lokasi & Kontak
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'desa.required' => 'Desa wajib diisi.',
            'nama_ketua.required' => 'Nama ketua KTH wajib diisi.',
            'no_hp_ketua.required' => 'Nomor HP ketua wajib diisi.',

            // Koordinat
            'latitude.required' => 'Latitude wajib diisi. Klik peta untuk menentukan koordinat.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',
            'longitude.required' => 'Longitude wajib diisi. Klik peta untuk menentukan koordinat.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',

            // Status
            'status_kth.required' => 'Status KTH wajib dipilih.',
            'tahun_tidak_aktif.min' => 'Tahun tidak aktif minimal 2000.',
            'tahun_tidak_aktif.max' => 'Tahun tidak aktif tidak boleh melebihi tahun ini.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set default kabupaten jika kosong
        if (empty($this->kabupaten)) {
            $this->merge(['kabupaten' => 'Sumenep']);
        }

        // Jika status Aktif, tahun_tidak_aktif harus null
        if ($this->status_kth === 'Aktif') {
            $this->merge(['tahun_tidak_aktif' => null]);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Jika status Tidak Aktif, tahun_tidak_aktif WAJIB diisi
            if ($this->status_kth === 'Tidak Aktif' && empty($this->tahun_tidak_aktif)) {
                $validator->errors()->add('tahun_tidak_aktif', 'Tahun tidak aktif wajib diisi jika status KTH Tidak Aktif.');
            }
        });
    }
}
