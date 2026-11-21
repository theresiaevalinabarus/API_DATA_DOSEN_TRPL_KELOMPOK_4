<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BuatAdminSeeder extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('admin');

        // Periksa apakah akun Admin sudah tersedia
        $adminSudahAda = $builder
            ->where('username', 'admin')
            ->countAllResults();

        if ($adminSudahAda > 0) {
            echo "Akun Admin sudah tersedia. Tidak membuat akun duplikat.\n";
            return;
        }

        // Data akun Admin pertama
        $dataAdmin = [
            'nama_admin' => 'Theresia Evalina Barus',
            'username'  => 'admin',
            'email'     => 'theresiaevalina@students.polmed.ac.id',

            // Password di-hash sebelum disimpan
            'password'  => password_hash(
                'KELOMPOK_4_OKE',
                PASSWORD_DEFAULT
            ),

            'is_active' => true
        ];

        // Simpan akun Admin ke database Supabase
        $builder->insert($dataAdmin);

        echo "====================================\n";
        echo "AKUN ADMIN BERHASIL DIBUAT!\n";
        echo "====================================\n";
        echo "Nama     : Theresia Evalina Barus\n";
        echo "Username : admin\n";
        echo "Email    : theresiaevalina@students.polmed.ac.id\n";
        echo "Password : Tersimpan dalam bentuk hash\n";
        echo "====================================\n";
    }
}