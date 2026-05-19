<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laptop;
use App\Models\Borrowing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name'  => 'Admin UNIBI',
            'email' => 'admin@unibi.ac.id',
            'password' => bcrypt('password'),
            'role'  => 'admin',
        ]);

        // Seed Categories
        $catGaming = \App\Models\Category::create([
            'name'        => 'Gaming & Rendering',
            'description' => 'Laptop spesifikasi tinggi dengan GPU diskrit untuk kebutuhan gaming, 3D modeling, dan rendering video.',
        ]);

        $catUltrabook = \App\Models\Category::create([
            'name'        => 'Ultrabook & Bisnis',
            'description' => 'Laptop tipis, ringan, dengan daya tahan baterai tinggi untuk kebutuhan mobilitas dan administrasi kantor.',
        ]);

        $catWorkstation = \App\Models\Category::create([
            'name'        => 'Developer & Workstation',
            'description' => 'Laptop performa tinggi dengan prosesor multi-core dan RAM besar untuk pemrograman, data science, dan virtualisasi.',
        ]);

        $laptops = [
            ['brand'=>'Lenovo','model'=>'ThinkPad E14','status'=>'tersedia','category_id'=>$catWorkstation->id],
            ['brand'=>'ASUS','model'=>'VivoBook 14','status'=>'tersedia','category_id'=>$catGaming->id],
            ['brand'=>'HP','model'=>'EliteBook 840','status'=>'dipinjam','category_id'=>$catUltrabook->id],
            ['brand'=>'Dell','model'=>'Inspiron 15','status'=>'tersedia','category_id'=>$catWorkstation->id],
            ['brand'=>'Acer','model'=>'Aspire 5','status'=>'tersedia','category_id'=>$catUltrabook->id],
        ];
        foreach ($laptops as $l) {
            Laptop::create($l);
        }

        // Contoh peminjaman tersebar per hari dengan beragam status untuk demo dashboard
        $borrowings = [
            // Monday, 2026-05-18
            [
                'borrower_name' => 'Budi S.',
                'borrow_date'   => '2026-05-18',
                'return_date'   => '2026-05-18', // return date passed relative to system date 2026-05-19 (Late!)
                'purpose'       => 'Tugas Akhir',
                'status'        => 'borrowed',
            ],
            [
                'borrower_name' => 'Ani R.',
                'borrow_date'   => '2026-05-18',
                'return_date'   => '2026-05-19', // returned today (since system date is 2026-05-19)
                'purpose'       => 'Presentasi',
                'status'        => 'returned',
            ],
            // Tuesday, 2026-05-19
            [
                'borrower_name' => 'Cahyo P.',
                'borrow_date'   => '2026-05-19',
                'return_date'   => '2026-05-22',
                'purpose'       => 'Ujian Praktikum',
                'status'        => 'borrowed',
            ],
            [
                'borrower_name' => 'Dini M.',
                'borrow_date'   => '2026-05-19',
                'return_date'   => '2026-05-22',
                'purpose'       => 'Penelitian',
                'status'        => 'rejected',
                'admin_note'    => 'Kondisi laptop sedang tidak stabil',
            ],
            [
                'borrower_name' => 'Eko F.',
                'borrow_date'   => '2026-05-19',
                'return_date'   => '2026-05-22',
                'purpose'       => 'KKN',
                'status'        => 'borrowed',
            ],
            // Wednesday, 2026-05-20 (Today)
            [
                'borrower_name' => 'Fira H.',
                'borrow_date'   => '2026-05-20',
                'return_date'   => '2026-05-23',
                'purpose'       => 'Tugas Akhir',
                'status'        => 'pending',
            ],
            // Thursday, 2026-05-21
            [
                'borrower_name' => 'Budi S.',
                'borrow_date'   => '2026-05-21',
                'return_date'   => '2026-05-24',
                'purpose'       => 'Presentasi',
                'status'        => 'pending',
            ],
            [
                'borrower_name' => 'Ani R.',
                'borrow_date'   => '2026-05-21',
                'return_date'   => '2026-05-24',
                'purpose'       => 'Ujian Praktikum',
                'status'        => 'borrowed',
            ],
            // Friday, 2026-05-22
            [
                'borrower_name' => 'Cahyo P.',
                'borrow_date'   => '2026-05-22',
                'return_date'   => '2026-05-25',
                'purpose'       => 'Penelitian',
                'status'        => 'borrowed',
            ],
            [
                'borrower_name' => 'Dini M.',
                'borrow_date'   => '2026-05-22',
                'return_date'   => '2026-05-25',
                'purpose'       => 'KKN',
                'status'        => 'borrowed',
            ],
            [
                'borrower_name' => 'Eko F.',
                'borrow_date'   => '2026-05-22',
                'return_date'   => '2026-05-25',
                'purpose'       => 'Tugas Akhir',
                'status'        => 'borrowed',
            ],
        ];

        foreach ($borrowings as $i => $data) {
            Borrowing::create(array_merge($data, [
                'user_id'   => null,
                'laptop_id' => ($i % 5) + 1,
            ]));
        }
    }
}