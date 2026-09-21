<?php

namespace App\Controllers;

use App\Models\AsnModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataAsn extends BaseController
{
    public function master_data_asn()
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

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        $data = $modelAsn
            ->where('is_delete_asn', '0')
            ->orderBy('nama_asn', 'ASC')
            ->findAll();

        $dataAsn = [
            'pages'    => $pages,
            'data_asn' => $data
        ];

        echo view('Backend/Template/header');
        echo view('Backend/Admin/DataAsn/data_asn', $dataAsn);
        echo view('Backend/Template/footer');
    }


    public function input_asn()
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

        echo view('Backend/Template/header');
        echo view('Backend/Admin/DataAsn/input_asn');
        echo view('Backend/Template/footer');
    }


    public function simpan_data_asn()
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


        // Ambil data dari form
        $nip = trim($this->request->getPost('nip'));
        $nama = trim($this->request->getPost('nama'));
        $email = trim($this->request->getPost('email'));
        $no_hp = trim($this->request->getPost('no_hp'));
        $alamat = trim($this->request->getPost('alamat'));
        $jabatan = trim($this->request->getPost('jabatan'));
        $pangkat_golongan = trim(
            $this->request->getPost('pangkat_golongan')
        );
        $unit_kerja = trim(
            $this->request->getPost('unit_kerja')
        );


        // Validasi field wajib
        if (
            $nip == "" ||
            $nama == "" ||
            $email == ""
        ) {
            session()->setFlashdata(
                'error',
                'NIP, Nama ASN, dan Email wajib diisi!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek NIP
        $cekNip = $modelAsn
            ->where('nip_asn', $nip)
            ->where('is_delete_asn', '0')
            ->countAllResults();

        if ($cekNip > 0) {
            session()->setFlashdata(
                'error',
                'NIP sudah terdaftar!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek Email
        $cekEmail = $modelAsn
            ->where('email_asn', $email)
            ->where('is_delete_asn', '0')
            ->countAllResults();

        if ($cekEmail > 0) {
            session()->setFlashdata(
                'error',
                'Email sudah terdaftar!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Generate ID ASN
        $dataTerakhir = $modelAsn
            ->orderBy('id_asn', 'DESC')
            ->first();

        if (!$dataTerakhir) {

            $idAsn = "ASN001";

        } else {

            $kode = $dataTerakhir['id_asn'];

            $noUrut = (int) substr($kode, -3);

            $noUrut++;

            $idAsn = "ASN" . sprintf(
                "%03d",
                $noUrut
            );
        }


        // Password awal = NIP
        $passwordHash = password_hash(
            $nip,
            PASSWORD_DEFAULT
        );


        // Data yang akan disimpan
        $dataSimpan = [

            'id_asn'               => $idAsn,
            'nip_asn'              => $nip,
            'nama_asn'             => $nama,
            'email_asn'            => $email,
            'password_asn'         => $passwordHash,
            'no_hp_asn'            => $no_hp,
            'alamat_asn'           => $alamat,
            'jabatan_asn'          => $jabatan,
            'pangkat_golongan_asn' => $pangkat_golongan,
            'unit_kerja_asn'       => $unit_kerja,
            'foto_asn'             => null,
            'is_delete_asn'        => '0',
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s')
        ];


        // Simpan
        $modelAsn->insert($dataSimpan);


        // Pesan berhasil
        session()->setFlashdata(
            'success',
            'Data ASN Berhasil Ditambahkan!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-asn'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // HAPUS DATA ASN TERPILIH - SOFT DELETE
    // =========================================================
    public function hapus_data_asn_terpilih()
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


        // Ambil data yang dipilih
        $idAsn = $this->request->getPost('id_asn');


        // Jika tidak ada yang dipilih
        if (empty($idAsn)) {

            session()->setFlashdata(
                'error',
                'Tidak ada data ASN yang dipilih!'
            );

            return redirect()->to(
                base_url('admin/master-data-asn')
            );
        }


        $modelAsn = new AsnModel();

        $jumlah = 0;


        // Proses soft delete
        foreach ($idAsn as $hash) {

            // Cari data berdasarkan SHA1 id_asn
            $dataAsn = $modelAsn
                ->where('SHA1(id_asn)', $hash)
                ->where('is_delete_asn', '0')
                ->first();


            if ($dataAsn) {

                // SOFT DELETE
                $modelAsn
                    ->where(
                        'id_asn',
                        $dataAsn['id_asn']
                    )
                    ->set([
                        'is_delete_asn' => '1',
                        'updated_at' => date(
                            'Y-m-d H:i:s'
                        )
                    ])
                    ->update();

                $jumlah++;
            }
        }


        // Pesan berhasil
        session()->setFlashdata(
            'success',
            $jumlah . ' data ASN berhasil dihapus!'
        );


        return redirect()->to(
            base_url('admin/master-data-asn')
        );
    }


    // =========================================================
    // IMPORT EXCEL ASN
    // =========================================================
    public function import_excel_asn()
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


        $modelAsn = new AsnModel();


        // Ambil file Excel
        $file = $this->request->getFile(
            'file_excel'
        );


        // Cek file
        if (!$file || !$file->isValid()) {

            session()->setFlashdata(
                'error',
                'File Excel tidak valid!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php

            return;
        }


        // Cek ekstensi
        $extension = strtolower(
            $file->getClientExtension()
        );


        if (
            !in_array(
                $extension,
                ['xlsx', 'xls']
            )
        ) {

            session()->setFlashdata(
                'error',
                'File harus berformat Excel (.xlsx atau .xls)!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php

            return;
        }


        try {

            // Baca file Excel
            $spreadsheet = IOFactory::load(
                $file->getTempName()
            );

            $sheet = $spreadsheet->getActiveSheet();


            // Ambil semua data
            $rows = $sheet->toArray(
                null,
                true,
                true,
                true
            );


            $berhasil = 0;
            $gagal = 0;


            // Mulai dari baris 2
            foreach (
                $rows as $nomorBaris => $row
            ) {

                if ($nomorBaris == 1) {
                    continue;
                }


                // Ambil data Excel
                $nip = trim(
                    (string) ($row['A'] ?? '')
                );

                $nama = trim(
                    (string) ($row['B'] ?? '')
                );

                $email = trim(
                    (string) ($row['C'] ?? '')
                );

                $no_hp = trim(
                    (string) ($row['D'] ?? '')
                );

                $alamat = trim(
                    (string) ($row['E'] ?? '')
                );

                $jabatan = trim(
                    (string) ($row['F'] ?? '')
                );

                $pangkat_golongan = trim(
                    (string) ($row['G'] ?? '')
                );

                $unit_kerja = trim(
                    (string) ($row['H'] ?? '')
                );


                // Lewati baris kosong
                if (
                    $nip == "" &&
                    $nama == "" &&
                    $email == ""
                ) {
                    continue;
                }


                // NIP, Nama, Email wajib
                if (
                    $nip == "" ||
                    $nama == "" ||
                    $email == ""
                ) {

                    $gagal++;

                    continue;
                }


                // Cek NIP aktif
                $cekNip = $modelAsn
                    ->where(
                        'nip_asn',
                        $nip
                    )
                    ->where(
                        'is_delete_asn',
                        '0'
                    )
                    ->countAllResults();


                if ($cekNip > 0) {

                    $gagal++;

                    continue;
                }


                // Cek Email aktif
                $cekEmail = $modelAsn
                    ->where(
                        'email_asn',
                        $email
                    )
                    ->where(
                        'is_delete_asn',
                        '0'
                    )
                    ->countAllResults();


                if ($cekEmail > 0) {

                    $gagal++;

                    continue;
                }


                // Generate ID ASN
                $dataTerakhir = $modelAsn
                    ->orderBy(
                        'id_asn',
                        'DESC'
                    )
                    ->first();


                if (!$dataTerakhir) {

                    $idAsn = "ASN001";

                } else {

                    $kode =
                        $dataTerakhir['id_asn'];

                    $noUrut = (int) substr(
                        $kode,
                        -3
                    );

                    $noUrut++;

                    $idAsn = "ASN" . sprintf(
                        "%03d",
                        $noUrut
                    );
                }


                // Password awal = NIP
                $passwordHash = password_hash(
                    $nip,
                    PASSWORD_DEFAULT
                );


                // Data ASN
                $dataSimpan = [

                    'id_asn' =>
                        $idAsn,

                    'nip_asn' =>
                        $nip,

                    'nama_asn' =>
                        $nama,

                    'email_asn' =>
                        $email,

                    'password_asn' =>
                        $passwordHash,

                    'no_hp_asn' =>
                        $no_hp,

                    'alamat_asn' =>
                        $alamat,

                    'jabatan_asn' =>
                        $jabatan,

                    'pangkat_golongan_asn' =>
                        $pangkat_golongan,

                    'unit_kerja_asn' =>
                        $unit_kerja,

                    'foto_asn' =>
                        null,

                    'is_delete_asn' =>
                        '0',

                    'created_at' =>
                        date('Y-m-d H:i:s'),

                    'updated_at' =>
                        date('Y-m-d H:i:s')
                ];


                // Simpan
                $modelAsn->insert(
                    $dataSimpan
                );

                $berhasil++;
            }


            // Pesan hasil import
            session()->setFlashdata(
                'success',
                'Import selesai! Berhasil: ' .
                $berhasil .
                ' data, Gagal: ' .
                $gagal .
                ' data.'
            );

        } catch (\Throwable $e) {

            session()->setFlashdata(
                'error',
                'Gagal membaca file Excel: ' .
                $e->getMessage()
            );
        }


        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-asn'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // EDIT DATA ASN
    // =========================================================
    public function edit_data_asn($id)
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


        $modelAsn = new AsnModel();


        // Ambil data ASN aktif
        $data = $modelAsn
            ->where(
                'is_delete_asn',
                '0'
            )
            ->findAll();


        $dataAsn = null;


        // Cari berdasarkan SHA1 id_asn
        foreach ($data as $row) {

            if (
                sha1($row['id_asn']) == $id
            ) {

                $dataAsn = $row;

                break;
            }
        }


        // Jika tidak ditemukan
        if (!$dataAsn) {

            session()->setFlashdata(
                'error',
                'Data ASN tidak ditemukan!'
            );

            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-asn'); ?>";
            </script>
            <?php

            return;
        }


        echo view(
            'Backend/Template/header'
        );

        echo view(
            'Backend/Admin/DataAsn/edit_asn',
            [
                'data_asn' => $dataAsn
            ]
        );

        echo view(
            'Backend/Template/footer'
        );
    }


    // =========================================================
    // UPDATE DATA ASN
    // =========================================================
    public function update_data_asn()
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


        $modelAsn = new AsnModel();


        // Ambil data form
        $id_asn =
            $this->request->getPost(
                'id_asn'
            );

        $nip = trim(
            $this->request->getPost(
                'nip'
            )
        );

        $nama = trim(
            $this->request->getPost(
                'nama'
            )
        );

        $email = trim(
            $this->request->getPost(
                'email'
            )
        );

        $no_hp = trim(
            $this->request->getPost(
                'no_hp'
            )
        );

        $alamat = trim(
            $this->request->getPost(
                'alamat'
            )
        );

        $jabatan = trim(
            $this->request->getPost(
                'jabatan'
            )
        );

        $pangkat_golongan = trim(
            $this->request->getPost(
                'pangkat_golongan'
            )
        );

        $unit_kerja = trim(
            $this->request->getPost(
                'unit_kerja'
            )
        );


        // Validasi
        if (
            $nip == "" ||
            $nama == "" ||
            $email == ""
        ) {

            session()->setFlashdata(
                'error',
                'NIP, Nama ASN, dan Email wajib diisi!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php

            return;
        }


        // Cek NIP ASN lain
        $cekNip = $modelAsn
            ->where(
                'nip_asn',
                $nip
            )
            ->where(
                'id_asn !=',
                $id_asn
            )
            ->where(
                'is_delete_asn',
                '0'
            )
            ->countAllResults();


        if ($cekNip > 0) {

            session()->setFlashdata(
                'error',
                'NIP sudah digunakan oleh ASN lain!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php

            return;
        }


        // Cek Email ASN lain
        $cekEmail = $modelAsn
            ->where(
                'email_asn',
                $email
            )
            ->where(
                'id_asn !=',
                $id_asn
            )
            ->where(
                'is_delete_asn',
                '0'
            )
            ->countAllResults();


        if ($cekEmail > 0) {

            session()->setFlashdata(
                'error',
                'Email sudah digunakan oleh ASN lain!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php

            return;
        }


        // Data update
        $dataUpdate = [

            'nip_asn' =>
                $nip,

            'nama_asn' =>
                $nama,

            'email_asn' =>
                $email,

            'no_hp_asn' =>
                $no_hp,

            'alamat_asn' =>
                $alamat,

            'jabatan_asn' =>
                $jabatan,

            'pangkat_golongan_asn' =>
                $pangkat_golongan,

            'unit_kerja_asn' =>
                $unit_kerja,

            'updated_at' =>
                date(
                    'Y-m-d H:i:s'
                )
        ];


        // Update
        $modelAsn
            ->where(
                'id_asn',
                $id_asn
            )
            ->set(
                $dataUpdate
            )
            ->update();


        session()->setFlashdata(
            'success',
            'Data ASN berhasil diperbarui!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-asn'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // HAPUS SATU DATA ASN - SOFT DELETE
    // =========================================================
    public function hapus_data_asn($id)
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


        $modelAsn = new AsnModel();


        // Ambil data ASN aktif
        $data = $modelAsn
            ->where(
                'is_delete_asn',
                '0'
            )
            ->findAll();


        $dataAsn = null;


        // Cari berdasarkan SHA1 id_asn
        foreach ($data as $row) {

            if (
                sha1($row['id_asn']) == $id
            ) {

                $dataAsn = $row;

                break;
            }
        }


        // Jika data tidak ditemukan
        if (!$dataAsn) {

            session()->setFlashdata(
                'error',
                'Data ASN tidak ditemukan!'
            );

            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-asn'); ?>";
            </script>
            <?php

            return;
        }


        // =====================================================
        // SOFT DELETE
        // Data tidak dihapus dari database
        // Hanya mengubah is_delete_asn menjadi 1
        // =====================================================
        $modelAsn
            ->where(
                'id_asn',
                $dataAsn['id_asn']
            )
            ->set([
                'is_delete_asn' => '1',
                'updated_at' => date(
                    'Y-m-d H:i:s'
                )
            ])
            ->update();


        session()->setFlashdata(
            'success',
            'Data ASN berhasil dihapus!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-asn'); ?>";
        </script>

        <?php
    }

    public function data_full()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_role') != 'asn') {
            session()->setFlashdata('error', 'Silakan login sebagai ASN terlebih dahulu!');
            return redirect()->to(base_url('/login'));
        }

        $modelAsn = new AsnModel();

        $data = $modelAsn
            ->where('is_delete_asn', '0')
            ->orderBy('nama_asn', 'ASC')
            ->findAll();

        echo view('Backend/Template/header');
        echo view('Backend/ASN/DataFull/data_full', ['data_asn' => $data]);
        echo view('Backend/Template/footer');
    }

}