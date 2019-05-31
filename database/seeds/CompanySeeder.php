<?php

use Illuminate\Database\Seeder;

use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Company::create([
            'is_visible' => true,
            'name' => 'Brandix Apparel Solutions Limited - Lingerie'
        ]);
    }
}
