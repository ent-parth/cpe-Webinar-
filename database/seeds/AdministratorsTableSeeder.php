<?php

use Illuminate\Database\Seeder;
use App\Models\Administrator;

class AdministratorsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Administrator::truncate();
        Schema::enableForeignKeyConstraints();
        $admin = [
            [
                'role_id' => 1,
                'first_name' => 'Sanjay',
                'last_name' => 'Chabhadiya',
                'email' => 'sanjay47c@gmail.com',
                'password' => bcrypt('Sanjay123'),
                'status' => config('constants.ADMIN_CONST.STATUS_ACTIVE'),
                'contact_no' => '7894561230',
            ]
        ];
        Administrator::insert($admin);
    }
}
