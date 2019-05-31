<?php

use Illuminate\Database\Seeder;

use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::create([
            'is_visible' => true,
            'name' => 'Industrial Engineering'
        ]);
    }
}
