<?php

use Illuminate\Database\Seeder;

class GeotrackingpolynesiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('geotrackingpolynesie')->insert([
            [
            'nomville' => 'RSMA',
            'lat' => -17.528650,
            'lon' => -149.530796
            ],
            [
            'nomville' => 'Ma maison',
            'lat' => -17.686144,
            'lon' => -149.570525
            ]
        ]);
    }
}
