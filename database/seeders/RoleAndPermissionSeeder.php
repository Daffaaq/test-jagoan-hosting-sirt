<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'master.management']);
        Permission::create(['name' => 'transaksi.management']);
        Permission::create(['name' => 'user.management']);
        Permission::create(['name' => 'role.permission.management']);
        Permission::create(['name' => 'menu.management']);
        //user
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.destroy']);
        Permission::create(['name' => 'user.import']);
        Permission::create(['name' => 'user.export']);

        //role
        Permission::create(['name' => 'role.index']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.destroy']);
        Permission::create(['name' => 'role.import']);
        Permission::create(['name' => 'role.export']);

        //permission
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.destroy']);
        Permission::create(['name' => 'permission.import']);
        Permission::create(['name' => 'permission.export']);

        //assignpermission
        Permission::create(['name' => 'assign.index']);
        Permission::create(['name' => 'assign.create']);
        Permission::create(['name' => 'assign.edit']);
        Permission::create(['name' => 'assign.destroy']);

        //assingusertorole
        Permission::create(['name' => 'assign.user.index']);
        Permission::create(['name' => 'assign.user.create']);
        Permission::create(['name' => 'assign.user.edit']);

        //menu group 
        Permission::create(['name' => 'menu-group.index']);
        Permission::create(['name' => 'menu-group.create']);
        Permission::create(['name' => 'menu-group.edit']);
        Permission::create(['name' => 'menu-group.destroy']);

        //menu item 
        Permission::create(['name' => 'menu-item.index']);
        Permission::create(['name' => 'menu-item.create']);
        Permission::create(['name' => 'menu-item.edit']);
        Permission::create(['name' => 'menu-item.destroy']);

        // rumah list
        Permission::create(['name' => 'rumah.index']);
        Permission::create(['name' => 'rumah.create']);
        Permission::create(['name' => 'rumah.edit']);
        Permission::create(['name' => 'rumah.destroy']);

        // penghuni list
        Permission::create(['name' => 'penghuni.index']);
        Permission::create(['name' => 'penghuni.create']);
        Permission::create(['name' => 'penghuni.edit']);
        Permission::create(['name' => 'penghuni.destroy']);

        // iuran list
        Permission::create(['name' => 'iuran.index']);
        Permission::create(['name' => 'iuran.create']);
        Permission::create(['name' => 'iuran.edit']);
        Permission::create(['name' => 'iuran.destroy']);

        //pembayaran
        Permission::create(['name' => 'pembayaran-iuran.index']);
        Permission::create(['name' => 'pembayaran-iuran.create']);
        Permission::create(['name' => 'pembayaran-iuran.edit']);
        Permission::create(['name' => 'pembayaran-iuran.destroy']);

        //pengeluaran
        Permission::create(['name' => 'pengeluaran.index']);
        Permission::create(['name' => 'pengeluaran.create']);
        Permission::create(['name' => 'pengeluaran.edit']);
        Permission::create(['name' => 'pengeluaran.destroy']);

        //laporan-bulanan
        Permission::create(['name' => 'laporan-bulanan.index']);
        Permission::create(['name' => 'laporan-bulanan.create']);
        Permission::create(['name' => 'laporan-bulanan.edit']);
        Permission::create(['name' => 'laporan-bulanan.destroy']);

        // rekap-saldo-tahunan
        Permission::create(['name' => 'rekap-saldo-tahunan.index']);
        Permission::create(['name' => 'rekap-saldo-tahunan.create']);
        Permission::create(['name' => 'rekap-saldo-tahunan.edit']);
        Permission::create(['name' => 'rekap-saldo-tahunan.destroy']);

        // create roles 
        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo([
            'dashboard',
            'user.management',
            'user.index',
        ]);

        // create Super Admin
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        //assign user id 1 ke super admin
        $user = User::find(1);
        $user->assignRole('super-admin');
        $user = User::find(2);
        $user->assignRole('user');
    }
}
