<?php

namespace Database\Seeders;

use App\Models\BarangGadai;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BarangGadaiSeeder::class,
        ]);
    }
}
