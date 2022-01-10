<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerGroup;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i <= 10; $i++) {

            CustomerGroup::create([
                'name' => 'Testovací skupina ' . $i,
            ]);

        }
    }
}
