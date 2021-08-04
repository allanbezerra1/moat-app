<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('defaults.permissions');
        if (count($permissions)) {
            foreach ($permissions as $permission) {
                $hasPermission = Permission::filterName($permission)->count();
                if (!$hasPermission) {
                    Permission::create(['name' => $permission]);
                }
            }
        }
    }
}
