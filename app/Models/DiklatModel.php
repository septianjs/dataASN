<?php

namespace App\Models;

use CodeIgniter\Model;

class DiklatModel extends Model
{
    protected $table = 'tbl_diklat';

    protected $primaryKey = 'id_diklat';

    protected $allowedFields = [
        'id_diklat',
        'id_asn',
        'nama_diklat',
        'jenis_diklat',
        'penyelenggara_diklat',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_diklat',
        'hasil_diklat',
        'is_delete_diklat',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
}