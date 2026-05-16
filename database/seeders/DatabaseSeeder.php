<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Laptop;        // tambah ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
{
    // Admin
    User::create([
        'name'     => 'Mr.Arya',
        'email'    => 'admin@lendlaptop.com',
        'password' => bcrypt('adminlaptop'),
        'role'     => 'admin',
    ]);

    // User biasa
    User::create([
        'name'     => 'Budi Santoso',
        'email'    => 'budi@sekolah.sch.id',
        'password' => bcrypt('password'),
        'role'     => 'user',
        'kelas'    => 'XII RPL 1',
        'phone'    => '081234567890',
    ]);

    // Kategori
    $office  = Category::create(['name' => 'Office',  'description' => 'Laptop untuk keperluan kantor']);
    $gaming  = Category::create(['name' => 'Gaming',  'description' => 'Laptop gaming performa tinggi']);
    $design  = Category::create(['name' => 'Design',  'description' => 'Laptop untuk desain grafis']);

    // Laptop dummy
    Laptop::create([
        'category_id'   => $design->id,
        'code'          => 'LP-001',
        'brand'         => 'Apple',
        'model'         => 'MacBook Pro 14"',
        'processor'     => 'Apple M2 Pro',
        'ram'           => 16,
        'storage'       => '512GB SSD',
        'vga'           => 'Apple GPU 19-core',
        'serial_number' => 'SN-MBP001',
        'condition'     => 'baik',
        'status'        => 'tersedia',
    ]);

    Laptop::create([
        'category_id'   => $office->id,
        'code'          => 'LP-002',
        'brand'         => 'Dell',
        'model'         => 'XPS 15',
        'processor'     => 'Intel Core i7-12700H',
        'ram'           => 16,
        'storage'       => '1TB SSD',
        'vga'           => 'NVIDIA RTX 3050',
        'serial_number' => 'SN-DELL002',
        'condition'     => 'baik',
        'status'        => 'dipinjam',
    ]);

    // tambahkan laptop lainnya sesuai kebutuhan...
}
}