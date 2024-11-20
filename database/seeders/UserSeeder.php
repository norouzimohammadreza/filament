<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public static int $ADMIN_COUNT = 3;
    public static int $NONE_ADMIN_COUNT = 7;

    public function run(): void
    {

        for ($i = 0; $i < self::$ADMIN_COUNT; $i++) {
            $this->createAdmin();
        }

        for ($i = 0; $i < self::$NONE_ADMIN_COUNT; $i++) {
            $this->createNonAdmin();
        }
    }


    private function createAdmin($create = []): User
    {
        return DB::transaction(function () use ($create) {
            $adminRole = Role::firstOrCreate([
                'name' => config('filament-shield.super_admin.name'),
            ]);

            $adminUser = User::factory()->create($create);
            $adminUser->assignRole($adminRole);

            return $adminUser;
        });
    }
    private function createNonAdmin($create = []): User
    {
        return DB::transaction(function () use ($create) {
            $userRole = Role::firstOrCreate([
                'name' => config('filament-shield.panel_user.name'),
            ]);

            $user = User::factory()->create($create);
            $user->assignRole($userRole);

            return $user;
        });
    }
}
