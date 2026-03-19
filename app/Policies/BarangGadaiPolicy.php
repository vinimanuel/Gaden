<?php

namespace App\Policies;

use App\Models\BarangGadai;
use App\Models\User;

class BarangGadaiPolicy
{
    /**
     * Semua role yang aktif boleh melihat.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, BarangGadai $barang): bool
    {
        return $user->is_active;
    }

    /**
     * Hanya admin & kasir yang boleh buat gadai baru.
     */
    public function create(User $user): bool
    {
        return $user->canWrite();
    }

    /**
     * Admin & kasir boleh edit, tapi tidak bisa edit yang sudah ditebus.
     */
    public function update(User $user, BarangGadai $barang): bool
    {
        return $user->canWrite() && $barang->status !== 'ditebus';
    }

    /**
     * Hanya admin yang boleh hapus.
     */
    public function delete(User $user, BarangGadai $barang): bool
    {
        return $user->canDelete();
    }

    /**
     * Admin & kasir boleh tebus/perpanjang barang aktif.
     */
    public function tebus(User $user, BarangGadai $barang): bool
    {
        return $user->canWrite() && $barang->status === 'aktif';
    }

    public function perpanjang(User $user, BarangGadai $barang): bool
    {
        return $user->canWrite() && $barang->status === 'aktif';
    }
}
