<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static bool $useSeed = true;
    public static int $RANDOM_SEED = 14658;

    /* TODO
    1. bugs
    2. admin_customer
    3. roles and permissions (model_has_permissions, permissions, role_has_permissions)
    */

    public function run(): void
    {
        if (self::$useSeed)
            srand(self::$RANDOM_SEED);

        $this->call([
            UserSeeder::class,
            ShieldSeeder::class,
        ]);

        if (self::$useSeed)
            srand();
    }
}
