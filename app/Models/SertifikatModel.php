<?php

namespace App\Models;

use CodeIgniter\Model;

class SertifikatModel extends Model
{
    protected $table = 'tbl_sertifikat';

    protected $primaryKey = 'id_sertifikat';

    protected $allowedFields = [
        'id_sertifikat',
        'id_asn',
        'nama_sertifikat',
        'nomor_sertifikat',
        'tanggal_terbit',
        'status_sertifikat',
        'file_sertifikat',
        'is_delete_sertifikat',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
}