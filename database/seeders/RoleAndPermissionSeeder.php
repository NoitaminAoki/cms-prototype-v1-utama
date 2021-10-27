<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::create([
            'name' => 'Admin 1',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        $arrayOfPermissionNames = [
            'kas-besar view',
            'kas-besar add', 
            'kas-besar update',
            'kas-besar delete',
            'pengajuan-dana view',
            'pengajuan-dana add', 
            'pengajuan-dana update',
            'pengajuan-dana delete',
            'realisasi-dana view',
            'realisasi-dana add', 
            'realisasi-dana update',
            'realisasi-dana delete',
            'kwitansi view',
            'kwitansi add', 
            'kwitansi update',
            'kwitansi delete',
            'jurnal-harian view', 
            'jurnal-harian add', 
            'jurnal-harian update',
            'jurnal-harian delete',
            'jurnal-keuangan view', 
            'progress-keuangan view', 
            'progress-keuangan add', 
            'progress-keuangan update', 
            'progress-keuangan delete', 
            'aset-perusahaan view',
            'item-aset-perusahaan add',
            'item-aset-perusahaan update',
            'item-aset-perusahaan delete',
            'inventori-perusahaan view',
            'inventori-perusahaan add',
            'inventori-perusahaan update',
            'inventori-perusahaan delete',
            'laporan-kegiatan view',
            'laporan-kegiatan add',
            'laporan-kegiatan update',
            'laporan-kegiatan delete',
            'legalitas-perusahaan view',
            'item-legalitas-perusahaan add',
            'item-legalitas-perusahaan update',
            'item-legalitas-perusahaan delete',
            'sdm-perusahaan view',
            'sdm-perusahaan add',
            'sdm-perusahaan update',
            'sdm-perusahaan delete',
            'marketing view',
            'item-marketing add',
            'item-marketing delete',
            'laporan-harian view',
            'laporan-harian add',
            'laporan-harian delete',
            'progress-kemajuan view',
            'item-progress-kemajuan add',
            'item-progress-kemajuan delete',
            'photo-kegiatan view',
            'photo-kegiatan add',
            'photo-kegiatan delete',
            'control-stock view',
            'control-stock add',
            'control-stock delete',
            'resume-kegiatan view',
            'resume-kegiatan add',
            'resume-kegiatan delete',
            'perjanjian-kontrak view',
            'perjanjian-kontrak add',
            'perjanjian-kontrak delete',

            'financial-analysis view',
            'financial-analysis add',
            'financial-analysis update',
            'financial-analysis delete',
            'gambar-unit-rumah view',
            'gambar-unit-rumah add',
            'gambar-unit-rumah update',
            'gambar-unit-rumah delete',
            'konstruksi-unit-rumah view',
            'konstruksi-unit-rumah add',
            'konstruksi-unit-rumah update',
            'konstruksi-unit-rumah delete',
            'item-unit-rumah view',
            'item-unit-rumah add',
            'item-unit-rumah update',
            'item-unit-rumah delete',
            'konstruksi-sarana view',
            'item-konstruksi-sarana add',
            'item-konstruksi-sarana delete',
            'brosur-perumahan view',
            'brosur-perumahan add',
            'brosur-perumahan delete',

        ];

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        $admin_permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'admin'];
        });
    
        Permission::insert($permissions->toArray());
        Permission::insert($admin_permissions->toArray());
        $list_permission = Permission::where([['guard_name', '=', 'admin']])->get();
        // dd($list_permission);
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $role->syncPermissions($list_permission);

        // $user->givePermissionTo([$arrayOfPermissionNames]);
        // $user->assignRole(['jurnal harian']);

        // dump('user has permission [jurnal-harian view]: '.$user->hasPermissionTo('jurnal-harian view'));
        // dump('user has permission [jurnal-harian add]: '.$user->hasPermissionTo('jurnal-harian add'));
        // dump('user has permission [jurnal-harian update]: '.$user->hasPermissionTo('jurnal-harian update'));
        // dump('user has permission [jurnal-harian delete]: '.$user->hasPermissionTo('jurnal-harian delete'));
    }
}
