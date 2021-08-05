<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            'album-list',
            'album-edit',

        ];
        $roles = config('defaults.roles');
        if (count($roles)) {
            foreach ($roles as $role) {
                $hasRole = Role::filterName($role)->count();
                if (!$hasRole) {
                    $defaultRole = Role::create(['name' => $role]);
                    if ($defaultRole && $role == "user") {
                        $defaultRole->syncPermissions($user);
                    }
                    if ($defaultRole && $role == "admin") {
                        $defaultRole->syncPermissions(Permission::whereIn('name', config('defaults.permissions'))->get());
                    }
                } else {
                    $defaultRole = Role::filterName($role)->first();
                    if ($defaultRole && $role == "admin") {
                        $defaultRole->syncPermissions(Permission::whereIn('name', config('defaults.permissions'))->get());
                    }
                    if ($defaultRole && $role == "user") {
                        $defaultRole->syncPermissions(Permission::whereIn('name', $user)->get());
                    }
                }
            }
        }
    }
}
