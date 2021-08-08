<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\City;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach ($daftarProvinsi as $provinceRow) {
            Province::create([
                'id_province' => $provinceRow['province_id'],
                'name' => $provinceRow['province'],
            ]);
            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
            foreach ($daftarKota as $cityRow) {
                City::create([
                    'province_id' => $provinceRow['province_id'],
                    'id_city' => $cityRow['city_id'],
                    'name' => $cityRow['city_name'],
                ]);
            }
        }
    }
}
