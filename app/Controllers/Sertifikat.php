<?php

namespace App\Controllers;

use App\Models\SertifikatModel;
use App\Models\AsnModel;

class Sertifikat extends BaseController
{
    public function master_data_sertifikat()
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

        $modelSertifikat = new SertifikatModel();

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        /*
         * Ambil data sertifikat
         * sekaligus NIP dan nama ASN
         */
        $data = $modelSertifikat
            ->select('
                tbl_sertifikat.*,
                tbl_asn.nip_asn,
                tbl_asn.nama_asn
            ')
            ->join(
                'tbl_asn',
                'tbl_asn.id_asn = tbl_sertifikat.id_asn',
                'left'
            )
            ->where(
                'tbl_sertifikat.is_delete_sertifikat',
                '0'
            )
            ->orderBy(
                'tbl_sertifikat.tanggal_terbit',
                'DESC'
            )
            ->findAll();

        $dataSertifikat = [
            'pages'             => $pages,
            'data_sertifikat'   => $data
        ];

        echo view('Backend/Admin/Template/header');
        echo view(
            'Backend/Admin/Sertifikat/data_sertifikat',
            $dataSertifikat
        );
        echo view('Backend/Admin/Template/footer');
    }


    public function input_sertifikat()
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

        /*
         * Ambil ASN yang masih aktif
         */
        $dataAsn = $modelAsn
            ->where('is_delete_asn', '0')
            ->orderBy('nama_asn', 'ASC')
            ->findAll();

        echo view('Backend/Admin/Template/header');

        echo view(
            'Backend/Admin/Sertifikat/input_sertifikat',
            [
                'data_asn' => $dataAsn
            ]
        );

        echo view('Backend/Admin/Template/footer');
    }


    public function simpan_data_sertifikat()
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

        $modelSertifikat = new SertifikatModel();
        $modelAsn = new AsnModel();


        // Ambil data dari form
        $id_asn = trim(
            $this->request->getPost('id_asn')
        );

        $nama_sertifikat = trim(
            $this->request->getPost('nama_sertifikat')
        );

        $nomor_sertifikat = trim(
            $this->request->getPost('nomor_sertifikat')
        );

        $tanggal_terbit = trim(
            $this->request->getPost('tanggal_terbit')
        );

        $status_sertifikat = trim(
            $this->request->getPost('status_sertifikat')
        );


        // Validasi field wajib
        if (
            $id_asn == "" ||
            $nama_sertifikat == "" ||
            $nomor_sertifikat == "" ||
            $tanggal_terbit == "" ||
            $status_sertifikat == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data sertifikat wajib diisi!'
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
                $status_sertifikat,
                ['Valid', 'Tidak Valid']
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status sertifikat tidak valid!'
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
            ->where('id_asn', $id_asn)
            ->where('is_delete_asn', '0')
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


        // Cek nomor sertifikat
        $cekNomor = $modelSertifikat
            ->where(
                'nomor_sertifikat',
                $nomor_sertifikat
            )
            ->where(
                'is_delete_sertifikat',
                '0'
            )
            ->countAllResults();

        if ($cekNomor > 0) {
            session()->setFlashdata(
                'error',
                'Nomor sertifikat sudah terdaftar!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Generate ID Sertifikat
        $idSertifikat = $this->generateIdSertifikat();


        // Ambil file sertifikat
        $file = $this->request->getFile(
            'file_sertifikat'
        );

        $namaFile = null;


        // Jika ada file
        if (
            $file &&
            $file->isValid() &&
            !$file->hasMoved()
        ) {

            // Cek ekstensi
            $extension = strtolower(
                $file->getClientExtension()
            );

            if (
                !in_array(
                    $extension,
                    ['jpg', 'jpeg', 'png']
                )
            ) {
                session()->setFlashdata(
                    'error',
                    'Foto sertifikat harus JPG, JPEG, atau PNG!'
                );
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }


            // Cek ukuran maksimal 5 MB
            if (
                $file->getSize() >
                5 * 1024 * 1024
            ) {
                session()->setFlashdata(
                    'error',
                    'Ukuran foto sertifikat maksimal 5 MB!'
                );
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }


            // Folder upload
            $folder = FCPATH .
                'uploads/sertifikat/';


            if (!is_dir($folder)) {
                mkdir(
                    $folder,
                    0777,
                    true
                );
            }


            // Nama file random
            $namaFile =
                $file->getRandomName();


            // Pindahkan file
            $file->move(
                $folder,
                $namaFile
            );
        }


        // Data yang akan disimpan
        $dataSimpan = [

            'id_sertifikat' =>
                $idSertifikat,

            'id_asn' =>
                $id_asn,

            'nama_sertifikat' =>
                $nama_sertifikat,

            'nomor_sertifikat' =>
                $nomor_sertifikat,

            'tanggal_terbit' =>
                $tanggal_terbit,

            'status_sertifikat' =>
                $status_sertifikat,

            'file_sertifikat' =>
                $namaFile,

            'is_delete_sertifikat' =>
                '0',

            'created_at' =>
                date('Y-m-d H:i:s'),

            'updated_at' =>
                date('Y-m-d H:i:s')
        ];


        // Simpan data
        $modelSertifikat->insert(
            $dataSimpan
        );


        // Pesan berhasil
        session()->setFlashdata(
            'success',
            'Data sertifikat berhasil ditambahkan!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-sertifikat'); ?>";
        </script>

        <?php
    }


    private function generateIdSertifikat()
    {
        $modelSertifikat =
            new SertifikatModel();


        /*
         * Ambil ID terakhir.
         *
         * Contoh:
         * SRT001
         * SRT002
         * SRT003
         */
        $dataTerakhir = $modelSertifikat
            ->orderBy(
                'id_sertifikat',
                'DESC'
            )
            ->first();


        if (!$dataTerakhir) {
            return 'SRT001';
        }


        $kode = $dataTerakhir[
            'id_sertifikat'
        ];


        /*
         * Ambil 3 angka terakhir
         */
        $noUrut = (int) substr(
            $kode,
            -3
        );


        $noUrut++;


        return 'SRT' .
            sprintf(
                '%03d',
                $noUrut
            );
    }


    public function edit_data_sertifikat($id)
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

        $modelSertifikat =
            new SertifikatModel();

        $modelAsn =
            new AsnModel();


        /*
         * Cari data berdasarkan SHA1
         */
        $data = $modelSertifikat
            ->where(
                'is_delete_sertifikat',
                '0'
            )
            ->findAll();

        $dataSertifikat = null;


        foreach ($data as $row) {

            if (
                sha1(
                    $row['id_sertifikat']
                ) == $id
            ) {
                $dataSertifikat = $row;
                break;
            }
        }


        // Jika tidak ditemukan
        if (!$dataSertifikat) {

            session()->setFlashdata(
                'error',
                'Data sertifikat tidak ditemukan!'
            );
            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-sertifikat'); ?>";
            </script>
            <?php
            return;
        }


        /*
         * Ambil data ASN
         */
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
            'Backend/Admin/Sertifikat/edit_sertifikat',
            [
                'data_sertifikat' =>
                    $dataSertifikat,

                'data_asn' =>
                    $dataAsn
            ]
        );

        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    public function update_data_sertifikat()
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

        $modelSertifikat =
            new SertifikatModel();


        // ID sertifikat
        $id_sertifikat =
            $this->request->getPost(
                'id_sertifikat'
            );


        // Ambil data form
        $id_asn = trim(
            $this->request->getPost(
                'id_asn'
            )
        );

        $nama_sertifikat = trim(
            $this->request->getPost(
                'nama_sertifikat'
            )
        );

        $nomor_sertifikat = trim(
            $this->request->getPost(
                'nomor_sertifikat'
            )
        );

        $tanggal_terbit = trim(
            $this->request->getPost(
                'tanggal_terbit'
            )
        );

        $status_sertifikat = trim(
            $this->request->getPost(
                'status_sertifikat'
            )
        );


        // Validasi
        if (
            $id_sertifikat == "" ||
            $id_asn == "" ||
            $nama_sertifikat == "" ||
            $nomor_sertifikat == "" ||
            $tanggal_terbit == "" ||
            $status_sertifikat == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data sertifikat wajib diisi!'
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
                $status_sertifikat,
                ['Valid', 'Tidak Valid']
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status sertifikat tidak valid!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek nomor sertifikat
        $cekNomor = $modelSertifikat
            ->where(
                'nomor_sertifikat',
                $nomor_sertifikat
            )
            ->where(
                'id_sertifikat !=',
                $id_sertifikat
            )
            ->where(
                'is_delete_sertifikat',
                '0'
            )
            ->countAllResults();


        if ($cekNomor > 0) {

            session()->setFlashdata(
                'error',
                'Nomor sertifikat sudah digunakan oleh sertifikat lain!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Ambil data lama
        $dataLama = $modelSertifikat
            ->where(
                'id_sertifikat',
                $id_sertifikat
            )
            ->first();


        if (!$dataLama) {

            session()->setFlashdata(
                'error',
                'Data sertifikat tidak ditemukan!'
            );
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Ambil file baru
        $file = $this->request->getFile(
            'file_sertifikat'
        );

        $namaFile = $dataLama[
            'file_sertifikat'
        ];


        /*
         * Jika user memilih foto baru
         */
        if (
            $file &&
            $file->isValid() &&
            !$file->hasMoved()
        ) {

            $extension = strtolower(
                $file->getClientExtension()
            );


            // Validasi ekstensi
            if (
                !in_array(
                    $extension,
                    ['jpg', 'jpeg', 'png']
                )
            ) {

                session()->setFlashdata(
                    'error',
                    'Foto sertifikat harus JPG, JPEG, atau PNG!'
                );
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }


            // Validasi ukuran
            if (
                $file->getSize() >
                5 * 1024 * 1024
            ) {

                session()->setFlashdata(
                    'error',
                    'Ukuran foto sertifikat maksimal 5 MB!'
                );
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }


            // Folder upload
            $folder = FCPATH .
                'uploads/sertifikat/';


            if (!is_dir($folder)) {

                mkdir(
                    $folder,
                    0777,
                    true
                );
            }


            // Hapus foto lama
            if (
                !empty(
                    $dataLama[
                        'file_sertifikat'
                    ]
                )
            ) {

                $fileLama =
                    $folder .
                    $dataLama[
                        'file_sertifikat'
                    ];

                if (
                    file_exists(
                        $fileLama
                    )
                ) {
                    unlink(
                        $fileLama
                    );
                }
            }


            // Nama file baru
            $namaFile =
                $file->getRandomName();


            // Upload
            $file->move(
                $folder,
                $namaFile
            );
        }


        // Data update
        $dataUpdate = [

            'id_asn' =>
                $id_asn,

            'nama_sertifikat' =>
                $nama_sertifikat,

            'nomor_sertifikat' =>
                $nomor_sertifikat,

            'tanggal_terbit' =>
                $tanggal_terbit,

            'status_sertifikat' =>
                $status_sertifikat,

            'file_sertifikat' =>
                $namaFile,

            'updated_at' =>
                date('Y-m-d H:i:s')
        ];


        // Update
        $modelSertifikat
            ->where(
                'id_sertifikat',
                $id_sertifikat
            )
            ->set($dataUpdate)
            ->update();


        session()->setFlashdata(
            'success',
            'Data sertifikat berhasil diperbarui!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-sertifikat'); ?>";
        </script>

        <?php
    }


    public function hapus_data_sertifikat($id)
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

        $modelSertifikat =
            new SertifikatModel();


        /*
         * Cari data berdasarkan SHA1
         */
        $data = $modelSertifikat
            ->where(
                'is_delete_sertifikat',
                '0'
            )
            ->findAll();

        $dataSertifikat = null;


        foreach ($data as $row) {

            if (
                sha1(
                    $row['id_sertifikat']
                ) == $id
            ) {
                $dataSertifikat = $row;
                break;
            }
        }


        // Jika tidak ditemukan
        if (!$dataSertifikat) {

            session()->setFlashdata(
                'error',
                'Data sertifikat tidak ditemukan!'
            );
            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-sertifikat'); ?>";
            </script>
            <?php
            return;
        }


        /*
         * Hapus foto sertifikat
         */
        if (
            !empty(
                $dataSertifikat[
                    'file_sertifikat'
                ]
            )
        ) {

            $file =
                FCPATH .
                'uploads/sertifikat/' .
                $dataSertifikat[
                    'file_sertifikat'
                ];

            if (
                file_exists($file)
            ) {
                unlink($file);
            }
        }


                /*
        * Delete permanen
        */
        $modelSertifikat
            ->where(
                'id_sertifikat',
                $dataSertifikat[
                    'id_sertifikat'
                ]
            )
            ->delete();

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-sertifikat'); ?>";
        </script>

        <?php
    }

    public function cek_asn()
    {
        $nip = (string) session()->get('ses_nip');
        $data = [];

        if ($nip !== '') {
            $data = (new SertifikatModel())
                ->select('tbl_sertifikat.*, tbl_asn.nip_asn, tbl_asn.nama_asn')
                ->join('tbl_asn', 'tbl_asn.id_asn = tbl_sertifikat.id_asn', 'left')
                ->where('tbl_sertifikat.is_delete_sertifikat', '0')
                ->where('tbl_asn.nip_asn', $nip)
                ->orderBy('tbl_sertifikat.tanggal_terbit', 'DESC')
                ->findAll();
        }

        echo view('Backend/ASN/Template/header');
        echo view('Backend/ASN/Sertifikat/cek_sertifikat', [
            'nip' => $nip,
            'data_sertifikat' => $data
        ]);
        echo view('Backend/ASN/Template/footer');
    }

}