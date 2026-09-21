<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table = 'tbl_gaji';

    protected $primaryKey = 'id_gaji';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_gaji',
        'nip_asn',
        'bulan_gaji',
        'tahun_gaji',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_diterima',
        'status_gaji',
        'is_delete_gaji',
        'created_at',
        'updated_at'
    ];


    /**
     * Ambil semua data gaji
     * sekaligus nama ASN berdasarkan NIP
     */
    public function getDataGaji()
    {
        return $this->select('
                tbl_gaji.*,
                tbl_asn.nama_asn
            ')
            ->join(
                'tbl_asn',
                'tbl_asn.nip_asn = tbl_gaji.nip_asn',
                'left'
            )
            ->where(
                'tbl_gaji.is_delete_gaji',
                '0'
            )
            ->orderBy(
                'tbl_gaji.tahun_gaji',
                'DESC'
            )
            ->orderBy(
                'tbl_gaji.bulan_gaji',
                'DESC'
            )
            ->findAll();
    }


    /**
     * Ambil data gaji berdasarkan NIP
     */
    public function getGajiByNip($nip)
    {
        return $this->select('
                tbl_gaji.*,
                tbl_asn.nama_asn
            ')
            ->join(
                'tbl_asn',
                'tbl_asn.nip_asn = tbl_gaji.nip_asn',
                'left'
            )
            ->where(
                'tbl_gaji.nip_asn',
                $nip
            )
            ->where(
                'tbl_gaji.is_delete_gaji',
                '0'
            )
            ->orderBy(
                'tbl_gaji.tahun_gaji',
                'DESC'
            )
            ->orderBy(
                'tbl_gaji.bulan_gaji',
                'DESC'
            )
            ->findAll();
    }


    /**
     * Ambil satu data gaji berdasarkan ID
     */
    public function getGajiById($id)
    {
        return $this->select('
                tbl_gaji.*,
                tbl_asn.nama_asn
            ')
            ->join(
                'tbl_asn',
                'tbl_asn.nip_asn = tbl_gaji.nip_asn',
                'left'
            )
            ->where(
                'tbl_gaji.id_gaji',
                $id
            )
            ->where(
                'tbl_gaji.is_delete_gaji',
                '0'
            )
            ->first();
    }


    /**
     * Generate ID Gaji
     * Contoh: GJI001, GJI002, GJI003
     */
    public function generateIdGaji()
    {
        $lastData = $this->orderBy(
            'id_gaji',
            'DESC'
        )->first();

        if (!$lastData) {
            return 'GJI001';
        }

        $lastId = $lastData['id_gaji'];

        $number = (int) substr(
            $lastId,
            3
        );

        $number++;

        return 'GJI' . str_pad(
            $number,
            3,
            '0',
            STR_PAD_LEFT
        );
    }


    /**
     * Hitung total gaji
     *
     * Gaji Pokok + Tunjangan - Potongan
     */
    public function hitungTotal(
        $gajiPokok,
        $tunjangan,
        $potongan
    ) {
        return
            (float) $gajiPokok
            +
            (float) $tunjangan
            -
            (float) $potongan;
    }
}