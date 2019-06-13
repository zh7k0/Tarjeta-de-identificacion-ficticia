<?php

use Illuminate\Database\Seeder;

class GiroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Giro::class,10)->create();
    }
}
