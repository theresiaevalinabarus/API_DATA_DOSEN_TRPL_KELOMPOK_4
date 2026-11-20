<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'id_dosen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'kode_dosen',
        'nip',
        'nama',

        // Foreign key
        'id_jabatan',
        'id_status_prodi',
        'id_status_aktivitas',
        'id_pendidikan',
        'id_agama',

        // Kolom lama untuk kompatibilitas
        'jabatan_fungsional',
        'status_prodi',
        'status_aktivitas',
        'pendidikan_terakhir',
        'agama',

        // Informasi tambahan
        'tahun_lulus',
        'jenis_kelamin',
        'no_hp'
    ];
}
