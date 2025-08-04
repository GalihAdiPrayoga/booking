<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Helpers\EnumHelper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = EnumHelper::toArray(UserRoleEnum::class);

        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);

            $user = User::query()->create([
                'name' => $role,
                'email' => strtolower(str_replace(' ', '_', $role)) . '@gmail.com',
                'password' => bcrypt('password')
            ]);

            $user->assignRole($role);
        }
    }
}
