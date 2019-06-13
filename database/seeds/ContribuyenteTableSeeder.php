<?php

use Illuminate\Database\Seeder;

class ContribuyenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Contribuyente::class, 10)->create();
    }
}
