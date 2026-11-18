<?php
namespace App\Models;
use CodeIgniter\Model;
class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'id_dosen';
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_dosen',
        'nip',
        'nama',
        'jabatan_fungsional',
        'status_prodi',
        'pendidikan_terakhir',
        'status_aktivitas',
        'tahun_lulus',
        'jenis_kelamin',
        'no_hp',
        'agama'
    ];

    protected $useAutoIncrement = false;
}
