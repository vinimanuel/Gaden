<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya admin & kasir yang boleh buat gadai baru
        return $this->user()?->canWrite() ?? false;
    }

    public function rules(): array
    {
        return [
            'nasabah'        => 'required|string|max:150',
            'ktp'            => ['nullable', 'string', 'regex:/^\d{16}$/'],
            'no_telp'        => ['nullable', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'barang'         => 'required|string|max:200',
            'kategori'       => ['required', Rule::in(['Elektronik','Perhiasan','Kendaraan','Lainnya'])],
            'nilai_taksiran' => 'required|integer|min:10000|max:999999999',
            'nilai_pinjaman' => 'required|integer|min:10000|max:999999999|lte:nilai_taksiran',
            'tgl_gadai'      => 'required|date|before_or_equal:today',
            'bulan_gadai'    => 'required|integer|min:1|max:12',
            'keterangan'     => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'ktp.regex'                => 'Nomor KTP harus 16 digit angka.',
            'nilai_pinjaman.lte'       => 'Nilai pinjaman tidak boleh melebihi nilai taksiran.',
            'tgl_gadai.before_or_equal'=> 'Tanggal gadai tidak boleh di masa depan.',
            'nilai_taksiran.min'       => 'Nilai taksiran minimal Rp 10.000.',
            'nilai_pinjaman.min'       => 'Nilai pinjaman minimal Rp 10.000.',
        ];
    }
}
