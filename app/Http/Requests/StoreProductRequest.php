<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user punya izin buat melakukan request ini.
     */
    public function authorize(): bool
    {
        // PERBAIKAN: Wajib diubah jadi true! Kalau false, nanti error "Unauthorized"
        return true;
    }

    /**
     * Aturan validasi (dipindah dari Controller).
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            //'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Pesan error custom (bahasa sendiri).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Eh, nama produknya belum diisi lho!',
            'qty.required' => 'Jangan lupa isi jumlah produknya ya!',
            'qty.integer' => 'Jumlah produk harus berupa angka bulat.',
            'price.required' => 'Harganya wajib diisi biar bisa dijual!',
            'price.numeric' => 'Harga harus berupa angka.',
            'user_id.required' => 'Pemilik produk (Owner) belum dipilih.',
        ];
    }
}