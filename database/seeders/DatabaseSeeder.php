<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\Permission;
use App\Models\Departement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $roles = json_decode(file_get_contents(database_path('seeders/data/roles.json')), true);
        foreach ($roles as $role) {
            $roleObj = Role::create([
                'name' => $role,
            ]);
        }

        $permissions = json_decode(file_get_contents(database_path('seeders/data/permissions.json')), true);
        foreach ($permissions as $permission) {
            $perm = Permission::create([
                'name' => $permission['name'],
                'module_name' => $permission['module_name'],
            ]);
            foreach ($permission['roles'] as $role) {
                $perm->assignRole($role);
            }

        }

        $users = json_decode(file_get_contents(database_path('seeders/data/users.json')), true);
        foreach ($users as $user) {
            $userObj = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'email_verified_at' => now(),
            ]);
            foreach ($user['roles'] as $role) {
                $userObj->assignRole($role);
            }

        }

        $departements = json_decode(file_get_contents(database_path('seeders/data/departemen.json')), true);
        foreach ($departements as $departement) {
            $userObj = Departement::create([
                'name' => $departement['name'],
            ]);

        }

        $positions = json_decode(file_get_contents(database_path('seeders/data/position.json')), true);
        foreach ($positions as $position) {
            $userObj = Position::create([
                'name' => $position['name'],
            ]);

        }

        $company = Company::create([
            'name' => 'Company',
        ]);

        // User::factory()->count(10000)->create()->each(function ($user) {
        //     $user->assignRole('user');
        // });

    }
}
