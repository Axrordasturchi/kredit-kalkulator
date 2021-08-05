<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->name='Admin';
        $user->email='admin@admin.com';
        $user->admin=1;
        $user->password=Hash::make('axror99');
        $user->save();
    }
}
