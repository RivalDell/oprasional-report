<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        Outlet::firstOrCreate(
            ['code' => 'SKD01'],
            ['name' => 'MOMOYO SUKADANA', 'address' => 'Jl. Merdeka Sukadana']
        );

        Outlet::firstOrCreate(
            ['code' => 'KTG01'],
            ['name' => 'MOMOYO KETAPANG', 'address' => 'Jl. Jendral Sudirman Ketapang']
        );
    }
}