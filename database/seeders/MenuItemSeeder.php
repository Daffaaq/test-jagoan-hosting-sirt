<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::insert([
            // Dashboard
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'permission_name' => 'dashboard',
                'menu_group_id' => 1,
            ],

            // Master Management (menu_group_id: 2)
            [
                'name' => 'Rumah List',
                'route' => 'master-management/rumah',
                'permission_name' => 'rumah.index',
                'menu_group_id' => 2,
            ],
            [
                'name' => 'Penghuni List',
                'route' => 'master-management/penghuni',
                'permission_name' => 'penghuni.index',
                'menu_group_id' => 2,
            ],
            [
                'name' => 'Iuran List',
                'route' => 'master-management/iuran',
                'permission_name' => 'iuran.index',
                'menu_group_id' => 2,
            ],

            // Transaksi Management (menu_group_id: 3)
            [
                'name' => 'Pembayaran Iuran',
                'route' => 'transaksi-management/pembayaran-iuran',
                'permission_name' => 'pembayaran-iuran.index',
                'menu_group_id' => 3,
            ],
            [
                'name' => 'Pengeluaran List',
                'route' => 'transaksi-management/pengeluaran',
                'permission_name' => 'pengeluaran.index',
                'menu_group_id' => 3,
            ],

            // Laporan Management (menu_group_id: 4)
            [
                'name' => 'Laporan Bulanan',
                'route' => 'laporan-management/laporan-bulanan',
                'permission_name' => 'laporan-bulanan.index',
                'menu_group_id' => 4,
            ],
            [
                'name' => 'Rekap Saldo Tahunan',
                'route' => 'laporan-management/rekap-saldo-tahunan',
                'permission_name' => 'rekap-saldo-tahunan.index',
                'menu_group_id' => 4,
            ],

            // Users Management (menu_group_id: 5)
            [
                'name' => 'User List',
                'route' => 'user-management/user',
                'permission_name' => 'user.index',
                'menu_group_id' => 5,
            ],

            // Role Management (menu_group_id: 6)
            [
                'name' => 'Role List',
                'route' => 'role-and-permission/role',
                'permission_name' => 'role.index',
                'menu_group_id' => 6,
            ],
            [
                'name' => 'Permission List',
                'route' => 'role-and-permission/permission',
                'permission_name' => 'permission.index',
                'menu_group_id' => 6,
            ],
            [
                'name' => 'Permission To Role',
                'route' => 'role-and-permission/assign',
                'permission_name' => 'assign.index',
                'menu_group_id' => 6,
            ],
            [
                'name' => 'User To Role',
                'route' => 'role-and-permission/assign-user',
                'permission_name' => 'assign.user.index',
                'menu_group_id' => 6,
            ],

            // Menu Management (menu_group_id: 7)
            [
                'name' => 'Menu Group',
                'route' => 'menu-management/menu-group',
                'permission_name' => 'menu-group.index',
                'menu_group_id' => 7,
            ],
            [
                'name' => 'Menu Item',
                'route' => 'menu-management/menu-item',
                'permission_name' => 'menu-item.index',
                'menu_group_id' => 7,
            ],
        ]);
    }
}
