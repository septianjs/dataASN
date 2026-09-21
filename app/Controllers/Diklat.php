<?php

namespace App\Controllers;

use App\Models\DiklatModel;
use App\Models\AsnModel;

class Diklat extends BaseController
{
    public function master_data_diklat()
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelDiklat = new DiklatModel();

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        // Ambil data diklat dan data ASN
        $data = $modelDiklat
            ->select('
                tbl_diklat.*,
                tbl_asn.nip_asn,
                tbl_asn.nama_asn
            ')
            ->join(
                'tbl_asn',
                'tbl_asn.id_asn = tbl_diklat.id_asn',
                'left'
            )
            ->where(
                'tbl_diklat.is_delete_diklat',
                '0'
            )
            ->orderBy(
                'tbl_diklat.tanggal_mulai',
                'DESC'
            )
            ->findAll();

        $dataDiklat = [
            'pages' => $pages,
            'data_diklat' => $data
        ];

        echo view('Backend/Admin/Template/header');
        echo view(
            'Backend/Admin/Diklat/data_diklat',
            $dataDiklat
        );
        echo view('Backend/Admin/Template/footer');
    }


    public function input_diklat()
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelAsn = new AsnModel();

        // Ambil ASN yang masih aktif
        $dataAsn = $modelAsn
            ->where(
                'is_delete_asn',
                '0'
            )
            ->orderBy(
                'nama_asn',
                'ASC'
            )
            ->findAll();

        echo view('Backend/Admin/Template/header');

        echo view(
            'Backend/Admin/Diklat/input_diklat',
            [
                'data_asn' => $dataAsn
            ]
        );

        echo view('Backend/Admin/Template/footer');
    }


    public function simpan_data_diklat()
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelDiklat = new DiklatModel();
        $modelAsn = new AsnModel();


        // Ambil data dari form
        $id_asn = trim(
            $this->request->getPost('id_asn')
        );

        $nama_diklat = trim(
            $this->request->getPost('nama_diklat')
        );

        $jenis_diklat = trim(
            $this->request->getPost('jenis_diklat')
        );

        $penyelenggara_diklat = trim(
            $this->request->getPost('penyelenggara_diklat')
        );

        $tanggal_mulai = trim(
            $this->request->getPost('tanggal_mulai')
        );

        $tanggal_selesai = trim(
            $this->request->getPost('tanggal_selesai')
        );

        $status_diklat = trim(
            $this->request->getPost('status_diklat')
        );

        $hasil_diklat = trim(
            $this->request->getPost('hasil_diklat')
        );


        // Validasi field wajib
        if (
            $id_asn == "" ||
            $nama_diklat == "" ||
            $jenis_diklat == "" ||
            $penyelenggara_diklat == "" ||
            $tanggal_mulai == "" ||
            $tanggal_selesai == "" ||
            $status_diklat == "" ||
            $hasil_diklat == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data diklat wajib diisi!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi tanggal
        if ($tanggal_selesai < $tanggal_mulai) {
            session()->setFlashdata(
                'error',
                'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi status
        if (
            !in_array(
                $status_diklat,
                [
                    'Terdaftar',
                    'Sedang Berlangsung',
                    'Selesai'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status diklat tidak valid!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi hasil
        if (
            !in_array(
                $hasil_diklat,
                [
                    'Lulus',
                    'Tidak Lulus',
                    'Belum Ada'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Hasil diklat tidak valid!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek ASN
        $dataAsn = $modelAsn
            ->where(
                'id_asn',
                $id_asn
            )
            ->where(
                'is_delete_asn',
                '0'
            )
            ->first();

        if (!$dataAsn) {
            session()->setFlashdata(
                'error',
                'Data ASN tidak ditemukan!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Generate ID Diklat
        $idDiklat =
            $this->generateIdDiklat();


        // Data yang akan disimpan
        $dataSimpan = [

            'id_diklat' =>
                $idDiklat,

            'id_asn' =>
                $id_asn,

            'nama_diklat' =>
                $nama_diklat,

            'jenis_diklat' =>
                $jenis_diklat,

            'penyelenggara_diklat' =>
                $penyelenggara_diklat,

            'tanggal_mulai' =>
                $tanggal_mulai,

            'tanggal_selesai' =>
                $tanggal_selesai,

            'status_diklat' =>
                $status_diklat,

            'hasil_diklat' =>
                $hasil_diklat,

            'is_delete_diklat' =>
                '0',

            'created_at' =>
                date('Y-m-d H:i:s'),

            'updated_at' =>
                date('Y-m-d H:i:s')
        ];


        // Simpan
        $modelDiklat->insert(
            $dataSimpan
        );


        session()->setFlashdata(
            'success',
            'Data diklat berhasil ditambahkan!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-diklat'); ?>";
        </script>

        <?php
    }


    private function generateIdDiklat()
    {
        $modelDiklat =
            new DiklatModel();


        // Ambil data terakhir
        $dataTerakhir = $modelDiklat
            ->orderBy(
                'id_diklat',
                'DESC'
            )
            ->first();


        if (!$dataTerakhir) {
            return 'DKL001';
        }


        $kode = $dataTerakhir[
            'id_diklat'
        ];


        // Ambil 3 angka terakhir
        $noUrut = (int) substr(
            $kode,
            -3
        );


        $noUrut++;


        return 'DKL' .
            sprintf(
                '%03d',
                $noUrut
            );
    }


    public function edit_data_diklat($id)
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelDiklat =
            new DiklatModel();

        $modelAsn =
            new AsnModel();


        // Cari data berdasarkan SHA1
        $data = $modelDiklat
            ->where(
                'is_delete_diklat',
                '0'
            )
            ->findAll();

        $dataDiklat = null;


        foreach ($data as $row) {

            if (
                sha1(
                    $row['id_diklat']
                ) == $id
            ) {
                $dataDiklat = $row;
                break;
            }
        }


        // Jika tidak ditemukan
        if (!$dataDiklat) {

            session()->setFlashdata(
                'error',
                'Data diklat tidak ditemukan!'
            );
            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-diklat'); ?>";
            </script>
            <?php
            return;
        }


        // Ambil data ASN
        $dataAsn = $modelAsn
            ->where(
                'is_delete_asn',
                '0'
            )
            ->orderBy(
                'nama_asn',
                'ASC'
            )
            ->findAll();


        echo view(
            'Backend/Admin/Template/header'
        );

        echo view(
            'Backend/Admin/Diklat/edit_diklat',
            [
                'data_diklat' => $dataDiklat,
                'data_asn' => $dataAsn
            ]
        );

        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    public function update_data_diklat()
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelDiklat =
            new DiklatModel();


        // ID diklat
        $id_diklat =
            $this->request->getPost(
                'id_diklat'
            );


        // Ambil data form
        $id_asn = trim(
            $this->request->getPost(
                'id_asn'
            )
        );

        $nama_diklat = trim(
            $this->request->getPost(
                'nama_diklat'
            )
        );

        $jenis_diklat = trim(
            $this->request->getPost(
                'jenis_diklat'
            )
        );

        $penyelenggara_diklat = trim(
            $this->request->getPost(
                'penyelenggara_diklat'
            )
        );

        $tanggal_mulai = trim(
            $this->request->getPost(
                'tanggal_mulai'
            )
        );

        $tanggal_selesai = trim(
            $this->request->getPost(
                'tanggal_selesai'
            )
        );

        $status_diklat = trim(
            $this->request->getPost(
                'status_diklat'
            )
        );

        $hasil_diklat = trim(
            $this->request->getPost(
                'hasil_diklat'
            )
        );


        // Validasi
        if (
            $id_diklat == "" ||
            $id_asn == "" ||
            $nama_diklat == "" ||
            $jenis_diklat == "" ||
            $penyelenggara_diklat == "" ||
            $tanggal_mulai == "" ||
            $tanggal_selesai == "" ||
            $status_diklat == "" ||
            $hasil_diklat == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data diklat wajib diisi!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi tanggal
        if ($tanggal_selesai < $tanggal_mulai) {
            session()->setFlashdata(
                'error',
                'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi status
        if (
            !in_array(
                $status_diklat,
                [
                    'Terdaftar',
                    'Sedang Berlangsung',
                    'Selesai'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status diklat tidak valid!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi hasil
        if (
            !in_array(
                $hasil_diklat,
                [
                    'Lulus',
                    'Tidak Lulus',
                    'Belum Ada'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Hasil diklat tidak valid!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek data lama
        $dataLama = $modelDiklat
            ->where(
                'id_diklat',
                $id_diklat
            )
            ->where(
                'is_delete_diklat',
                '0'
            )
            ->first();


        if (!$dataLama) {

            session()->setFlashdata(
                'error',
                'Data diklat tidak ditemukan!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Update data
        $dataUpdate = [

            'id_asn' =>
                $id_asn,

            'nama_diklat' =>
                $nama_diklat,

            'jenis_diklat' =>
                $jenis_diklat,

            'penyelenggara_diklat' =>
                $penyelenggara_diklat,

            'tanggal_mulai' =>
                $tanggal_mulai,

            'tanggal_selesai' =>
                $tanggal_selesai,

            'status_diklat' =>
                $status_diklat,

            'hasil_diklat' =>
                $hasil_diklat,

            'updated_at' =>
                date('Y-m-d H:i:s')
        ];


        $modelDiklat
            ->where(
                'id_diklat',
                $id_diklat
            )
            ->set($dataUpdate)
            ->update();


        session()->setFlashdata(
            'success',
            'Data diklat berhasil diperbarui!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-diklat'); ?>";
        </script>

        <?php
    }


    public function hapus_data_diklat($id)
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
            ?>
            <script>
                document.location =
                    "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
            return;
        }

        $modelDiklat =
            new DiklatModel();


        // Cari data berdasarkan SHA1
        $data = $modelDiklat
            ->where(
                'is_delete_diklat',
                '0'
            )
            ->findAll();

        $dataDiklat = null;


        foreach ($data as $row) {

            if (
                sha1(
                    $row['id_diklat']
                ) == $id
            ) {
                $dataDiklat = $row;
                break;
            }
        }


        // Jika tidak ditemukan
        if (!$dataDiklat) {

            session()->setFlashdata(
                'error',
                'Data diklat tidak ditemukan!'
            );
            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-diklat'); ?>";
            </script>
            <?php
            return;
        }


            // Delete permanen
        $modelDiklat
            ->where(
                'id_diklat',
                $dataDiklat[
                    'id_diklat'
                ]
            )
            ->delete();


        session()->setFlashdata(
            'success',
            'Data diklat berhasil dihapus!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-diklat'); ?>";
        </script>

        <?php
    }

    public function cek_asn()
    {
        $nip = (string) session()->get('ses_nip');
        $data = [];

        if ($nip !== '') {
            $data = (new DiklatModel())
                ->select('tbl_diklat.*, tbl_asn.nip_asn, tbl_asn.nama_asn')
                ->join('tbl_asn', 'tbl_asn.id_asn = tbl_diklat.id_asn', 'left')
                ->where('tbl_diklat.is_delete_diklat', '0')
                ->where('tbl_asn.nip_asn', $nip)
                ->orderBy('tbl_diklat.tanggal_mulai', 'DESC')
                ->findAll();
        }

        echo view('Backend/ASN/Template/header');
        echo view('Backend/ASN/Diklat/cek_diklat', [
            'nip' => $nip,
            'data_diklat' => $data
        ]);
        echo view('Backend/ASN/Template/footer');
    }

}