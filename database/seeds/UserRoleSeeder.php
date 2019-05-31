<?php

use Illuminate\Database\Seeder;

use App\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserRole::create([
            'is_visible' => false,
            'user_pk' => 'kasunv@brandix.com',
            'role_pk' => 'super-admin'
        ]);
    }
}
