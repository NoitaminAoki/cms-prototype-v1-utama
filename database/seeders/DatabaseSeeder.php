<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DivisiSeeder::class,
            MsCodeSeeder::class,
            MsSubCodeSeeder::class,
            RoleAndPermissionSeeder::class,
            AdminSeeder::class,
            KonstruksiUnitRumahSeeder::class,
            KonstruksiSaranaSeeder::class,
            AsetPerusahaanSeeder::class,
            LegalitasPerusahaanSeeder::class,
            MarketingSeeder::class,
            ProgressKemajuanSeeder::class,
        ]);
    }
}
