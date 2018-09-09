<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'first_name' => 'Goran',
            'last_name' => 'Dimitrovski',
            'email' => 'goran.dimitrovski@outlook.com',
            'password' => app('hash')->make('secret'),
        ]);
    }

}
