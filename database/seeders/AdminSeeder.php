<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User([
            'name' => 'StPronk',
            'email' => 'admin@stpronk.nl',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => 1
        ]);

        $user->save();
    }
}
