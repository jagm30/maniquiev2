<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_user = Role::where('name','user')->first();
        $role_admin = Role::where('name','admin')->first();

        $user = new User();
        $user->name = "User";
        $user->email = "josegijon30@hotmail.com";
        $user->password = bcrypt('12345678');
        $user->foto = "1.png";
        $user->save();

        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@hotmail.com";
        $user->password = bcrypt('12345678');
        $user->foto = "2.png";
        $user->save();

        $user->roles()->attach($role_admin);

        $user = new User();
        $user->name = "Maniquie";
        $user->email = "maniquie_2@hotmail.com";
        $user->password = bcrypt('felicidad');
        $user->foto = "maniquie.jpg";
        $user->save();

        $user->roles()->attach($role_admin);
    }
}
