<?php

namespace App\Models;

use CodeIgniter\Model;

class AsnModel extends Model
{
    protected $table = 'tbl_asn';

    protected $primaryKey = 'id_asn';

    protected $allowedFields = [
        'id_asn',
        'nip_asn',
        'nama_asn',
        'email_asn',
        'password_asn',
        'no_hp_asn',
        'alamat_asn',
        'jabatan_asn',
        'pangkat_golongan_asn',
        'unit_kerja_asn',
        'foto_asn',
        'is_delete_asn',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
}