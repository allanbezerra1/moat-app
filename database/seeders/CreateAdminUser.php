<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasAdmin = User::where('name', 'admin')->count();

        if (!$hasAdmin) {
            $admin = new User();
            $admin->full_name = 'admin teste';
            $admin->name = 'admin';
            $admin->password = bcrypt('12345678');
            $admin->save();
            $admin->syncRoles('admin');
        }
    }
}
