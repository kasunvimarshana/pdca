<?php

use Illuminate\Database\Seeder;

use App\Status;
use App\Enums\StatusEnum;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Status::create([
            //'id' => StatusEnum::DEFAULT,
            'id' => 1,
            'name' => 'DEFAULT',
            'is_visible' => false
        ]);
    }
}
