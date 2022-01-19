<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Kecamatan;
use App\Desa;
use App\Comment;
use App\WifiLocation;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kec = Kecamatan::create(['name' => 'Karawang Barat']);
        $des = Desa::create(['name' => 'Karang Pawitan', 'kecamatan_id' => $kec->id]);
        WifiLocation::create([
            'name' => 'Wifi Karang Pawitan', 
            'ssid_name' => 'WIFI KP', 
            'desc' => 'lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et',
            'is_active' => '1', 
            'latitude' => '-6.298008', 
            'longitude' => '107.298776',
            'kecamatan_id' => $kec->id,
            'desa_id' => $des->id,
        ]);

        $kec = Kecamatan::create(['name' => 'Karawang Timur']);
        $des = Desa::create(['name' => 'Kondang Jaya', 'kecamatan_id' => $kec->id]);
        WifiLocation::create([
            'name' => 'Wifi Kantor Desaa Kondang Jaya', 
            'ssid_name' => 'WIFI Kondang Jaya', 
            'desc' => 'lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et',
            'is_active' => '1', 
            'latitude' => '-6.335577', 
            'longitude' => '107.339115',
            'kecamatan_id' => $kec->id,
            'desa_id' => $des->id,
        ]);

    }
}

