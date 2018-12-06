<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'rember_token'])->toArray());

        $user = User::find(1);
        $user->name = '王根基';
        $user->email = '23333@gj.com';
        $user->password = bcrypt('xf1234');
        $user->is_admin =  true;
        $user->activated = false;
        $user->save();
    }
}
