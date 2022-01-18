<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Perusahaan;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perusahaan::create(['name' => 'PT Cinta Sejati']);
    }
}

