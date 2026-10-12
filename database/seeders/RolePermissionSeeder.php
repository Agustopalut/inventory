<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'melihat-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);
        Permission::create(['name' => 'input-user']);

        Permission::create(['name' => 'melihat-barang-master']);
        Permission::create(['name' => 'update-barang-master']);
        Permission::create(['name' => 'delete-barang-master']);
        Permission::create(['name' => 'input-barang-master']);

        Permission::create(['name' => 'melihat-barang-masuk']);
        Permission::create(['name' => 'update-barang-masuk']);
        Permission::create(['name' => 'delete-barang-masuk']);
        Permission::create(['name' => 'input-barang-masuk']);

        Permission::create(['name' => 'melihat-barang-keluar']);
        Permission::create(['name' => 'update-barang-keluar']);
        Permission::create(['name' => 'delete-barang-keluar']);
        Permission::create(['name' => 'input-barang-keluar']);

        Permission::create(['name' => 'melihat-stok-opname']);
        Permission::create(['name' => 'update-stok-opname']);
        Permission::create(['name' => 'delete-stok-opname']);
        Permission::create(['name' => 'input-stok-opname']);

        Permission::create(['name' => 'melihat-approval-request']);
        Permission::create(['name' => 'update-approval-request']);

        Permission::create(['name' => 'melihat-production-request']);
        Permission::create(['name' => 'input-production-request']);

        Permission::create(['name' => 'cetak-pdf']);

        Role::create(['name' =>'admin']);
        Role::create(['name' =>'guest']);
        Role::create(['name'=>'manager']);
        Role::create(['name'=>'production']);

        $roleAdmin = Role::findByName('admin');
        $roleGuest = Role::findByName('guest');
        $roleManager = Role::findByName('manager');
        $roleProduction = Role::findByName('production');

        $roleAdmin->givePermissionTo('melihat-user');
        $roleAdmin->givePermissionTo('update-user');
        $roleAdmin->givePermissionTo('delete-user');
        $roleAdmin->givePermissionTo('input-user');

        $roleAdmin->givePermissionTo('melihat-barang-masuk');
        $roleAdmin->givePermissionTo('update-barang-masuk');
        $roleAdmin->givePermissionTo('delete-barang-masuk');
        $roleAdmin->givePermissionTo('input-barang-masuk');

        $roleAdmin->givePermissionTo('melihat-barang-master');
        $roleAdmin->givePermissionTo('update-barang-master');
        $roleAdmin->givePermissionTo('delete-barang-master');
        $roleAdmin->givePermissionTo('input-barang-master');

        $roleAdmin->givePermissionTo('melihat-barang-keluar');
        $roleAdmin->givePermissionTo('delete-barang-keluar');
        $roleAdmin->givePermissionTo('input-barang-keluar');

        $roleAdmin->givePermissionTo('melihat-stok-opname');
        $roleAdmin->givePermissionTo('delete-stok-opname');
        $roleAdmin->givePermissionTo('input-stok-opname');

        $roleAdmin->givePermissionTo('melihat-approval-request');

        $roleAdmin->givePermissionTo('melihat-production-request');
        $roleAdmin->givePermissionTo('cetak-pdf');


        $roleGuest->givePermissionTo('melihat-barang-master');
        $roleGuest->givePermissionTo('melihat-barang-masuk');
        $roleGuest->givePermissionTo('melihat-barang-keluar');
        $roleGuest->givePermissionTo('melihat-stok-opname');
        $roleGuest->givePermissionTo('cetak-pdf');


        $roleManager->givePermissionTo('melihat-user');
        $roleManager->givePermissionTo('melihat-barang-master');
        $roleManager->givePermissionTo('melihat-barang-masuk');
        $roleManager->givePermissionTo('melihat-barang-keluar');
        $roleManager->givePermissionTo('melihat-stok-opname');
        $roleManager->givePermissionTo('melihat-approval-request');
        $roleManager->givePermissionTo('update-approval-request');
        $roleManager->givePermissionTo('melihat-production-request');
        $roleManager->givePermissionTo('cetak-pdf');

        $roleProduction->givePermissionTo('input-production-request');
        $roleProduction->givePermissionTo('melihat-production-request');
        
    }
}
