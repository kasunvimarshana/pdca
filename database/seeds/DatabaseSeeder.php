<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(PDCAMetaSeeder::class);
    }
}
