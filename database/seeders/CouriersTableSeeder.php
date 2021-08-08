<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Courier;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['code' => 'jne', 'name' => 'JNE', 'created_at' => new \DateTime, 'updated_at' => null],
            ['code' => 'pos', 'name' => 'POS', 'created_at' => new \DateTime, 'updated_at' => null],
            ['code' => 'tiki', 'name' => 'TIKI', 'created_at' => new \DateTime, 'updated_at' => null]
        ];
        Courier::insert($data);
    }
}
