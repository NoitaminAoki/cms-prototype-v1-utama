<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guards\Admin;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        $role = Role::where(['name' => 'Super Admin', 'guard_name' => 'admin'])->first();
        $admin->assignRole($role);
        
        // dump('admin has permission [jurnal-harian view]: '.$admin->hasPermissionTo('jurnal-harian view'));
        // dump('admin has permission [jurnal-harian add]: '.$admin->hasPermissionTo('jurnal-harian add'));
        // dump('admin has permission [jurnal-harian update]: '.$admin->hasPermissionTo('jurnal-harian update'));
        // dump('admin has permission [jurnal-harian delete]: '.$admin->hasPermissionTo('jurnal-harian delete'));
    }
}
