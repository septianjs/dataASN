<?php

namespace App\Controllers;

use App\Models\GajiModel;
use App\Models\AsnModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Gaji extends BaseController
{
    protected $gajiModel;
    protected $asnModel;

    public function __construct()
    {
        $this->gajiModel = new GajiModel();
        $this->asnModel  = new AsnModel();
    }


    // =========================================================
    // DATA GAJI
    // =========================================================
    public function index()
    {
        // Cek login
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

        // Ambil data gaji
        $dataGaji = $this->gajiModel
            ->getDataGaji();

        // Tampilkan header
        echo view(
            'Backend/Admin/Template/header'
        );

        // Tampilkan view data gaji
        echo view(
            'Backend/Admin/Gaji/data_gaji',
            [
                'data_gaji' => $dataGaji
            ]
        );

        // Tampilkan footer
        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    // =========================================================
    // FORM INPUT GAJI
    // =========================================================
    public function input()
    {
        // Cek login
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

        // Ambil data ASN
        $dataAsn = $this->asnModel
            ->where(
                'is_delete_asn',
                '0'
            )
            ->orderBy(
                'nama_asn',
                'ASC'
            )
            ->findAll();

        // Header
        echo view(
            'Backend/Admin/Template/header'
        );

        // View input
        echo view(
            'Backend/Admin/Gaji/input_gaji',
            [
                'data_asn' => $dataAsn
            ]
        );

        // Footer
        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    // =========================================================
    // PROSES INPUT GAJI
    // =========================================================
    public function proses_input()
    {
        // Cek login
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

        // Ambil data form
        $nip = trim(
            (string) $this->request->getPost('nip_asn')
        );

        $bulan = trim(
            (string) $this->request->getPost('bulan_gaji')
        );

        $tahun = trim(
            (string) $this->request->getPost('tahun_gaji')
        );

        $gajiPokok = trim(
            (string) $this->request->getPost('gaji_pokok')
        );

        $tunjangan = trim(
            (string) $this->request->getPost('tunjangan')
        );

        $potongan = trim(
            (string) $this->request->getPost('potongan')
        );

        $status = trim(
            (string) $this->request->getPost('status_gaji')
        );


        // Validasi wajib
        if (
            $nip == "" ||
            $bulan == "" ||
            $tahun == "" ||
            $gajiPokok == "" ||
            $tunjangan == "" ||
            $potongan == "" ||
            $status == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data gaji wajib diisi!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi NIP
        $asn = $this->asnModel
            ->where(
                'nip_asn',
                $nip
            )
            ->where(
                'is_delete_asn',
                '0'
            )
            ->first();

        if (!$asn) {
            session()->setFlashdata(
                'error',
                'NIP ASN tidak ditemukan!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi bulan
        if (
            !is_numeric($bulan) ||
            (int) $bulan < 1 ||
            (int) $bulan > 12
        ) {
            session()->setFlashdata(
                'error',
                'Bulan gaji harus antara 1 sampai 12!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi tahun
        if (
            !in_array(
                (int) $tahun,
                [2025, 2026]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Tahun gaji hanya boleh 2025 atau 2026!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi nominal
        if (
            !is_numeric($gajiPokok) ||
            !is_numeric($tunjangan) ||
            !is_numeric($potongan)
        ) {
            session()->setFlashdata(
                'error',
                'Gaji pokok, tunjangan, dan potongan harus berupa angka!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Nominal tidak boleh negatif
        if (
            (float) $gajiPokok < 0 ||
            (float) $tunjangan < 0 ||
            (float) $potongan < 0
        ) {
            session()->setFlashdata(
                'error',
                'Nominal gaji tidak boleh negatif!'
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
                $status,
                [
                    'Sudah Dibayar',
                    'Belum Dibayar'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status gaji tidak valid!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek duplikat
        $cek = $this->gajiModel
            ->where(
                'nip_asn',
                $nip
            )
            ->where(
                'bulan_gaji',
                (int) $bulan
            )
            ->where(
                'tahun_gaji',
                (int) $tahun
            )
            ->where(
                'is_delete_gaji',
                '0'
            )
            ->first();

        if ($cek) {
            session()->setFlashdata(
                'error',
                'Data gaji untuk NIP tersebut pada bulan dan tahun tersebut sudah ada!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Hitung total
        $totalDiterima =
            (float) $gajiPokok
            +
            (float) $tunjangan
            -
            (float) $potongan;


        // Generate ID
        $idGaji =
            $this->gajiModel
                ->generateIdGaji();


        // Data simpan
        $dataSimpan = [

            'id_gaji' =>
                $idGaji,

            'nip_asn' =>
                $nip,

            'bulan_gaji' =>
                (int) $bulan,

            'tahun_gaji' =>
                (int) $tahun,

            'gaji_pokok' =>
                (float) $gajiPokok,

            'tunjangan' =>
                (float) $tunjangan,

            'potongan' =>
                (float) $potongan,

            'total_diterima' =>
                $totalDiterima,

            'status_gaji' =>
                $status,

            'is_delete_gaji' =>
                '0',

            'created_at' =>
                date('Y-m-d H:i:s'),

            'updated_at' =>
                date('Y-m-d H:i:s')
        ];


        // Simpan
        $this->gajiModel
            ->insert($dataSimpan);


        session()->setFlashdata(
            'success',
            'Data gaji berhasil ditambahkan!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-gaji'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // FORM EDIT GAJI
    // =========================================================
    public function edit($hash)
    {
        // Cek login
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


        // Cari data berdasarkan SHA1
        $dataGaji = $this->gajiModel
            ->where(
                'SHA1(id_gaji)',
                $hash
            )
            ->first();


        // Jika tidak ditemukan
        if (!$dataGaji) {
            session()->setFlashdata(
                'error',
                'Data gaji tidak ditemukan!'
            );

            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-gaji'); ?>";
            </script>
            <?php
            return;
        }


        // Ambil ASN
        $dataAsn = $this->asnModel
            ->where(
                'is_delete_asn',
                '0'
            )
            ->orderBy(
                'nama_asn',
                'ASC'
            )
            ->findAll();


        // Header
        echo view(
            'Backend/Admin/Template/header'
        );


        // View edit
        echo view(
            'Backend/Admin/Gaji/edit_gaji',
            [
                'data_gaji' => $dataGaji,
                'data_asn'  => $dataAsn
            ]
        );


        // Footer
        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    // =========================================================
    // PROSES EDIT GAJI
    // =========================================================
    public function proses_edit($hash)
    {
        // Cek login
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


        // Cari data lama
        $dataGaji = $this->gajiModel
            ->where(
                'SHA1(id_gaji)',
                $hash
            )
            ->first();


        if (!$dataGaji) {
            session()->setFlashdata(
                'error',
                'Data gaji tidak ditemukan!'
            );

            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-gaji'); ?>";
            </script>
            <?php
            return;
        }


        // Ambil input
        $nip = trim(
            (string) $this->request->getPost('nip_asn')
        );

        $bulan = trim(
            (string) $this->request->getPost('bulan_gaji')
        );

        $tahun = trim(
            (string) $this->request->getPost('tahun_gaji')
        );

        $gajiPokok = trim(
            (string) $this->request->getPost('gaji_pokok')
        );

        $tunjangan = trim(
            (string) $this->request->getPost('tunjangan')
        );

        $potongan = trim(
            (string) $this->request->getPost('potongan')
        );

        $status = trim(
            (string) $this->request->getPost('status_gaji')
        );


        // Validasi wajib
        if (
            $nip == "" ||
            $bulan == "" ||
            $tahun == "" ||
            $gajiPokok == "" ||
            $tunjangan == "" ||
            $potongan == "" ||
            $status == ""
        ) {
            session()->setFlashdata(
                'error',
                'Semua data gaji wajib diisi!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi NIP
        $asn = $this->asnModel
            ->where(
                'nip_asn',
                $nip
            )
            ->where(
                'is_delete_asn',
                '0'
            )
            ->first();

        if (!$asn) {
            session()->setFlashdata(
                'error',
                'NIP ASN tidak ditemukan!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi bulan
        if (
            !is_numeric($bulan) ||
            (int) $bulan < 1 ||
            (int) $bulan > 12
        ) {
            session()->setFlashdata(
                'error',
                'Bulan gaji harus antara 1 sampai 12!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi tahun
        if (
            !in_array(
                (int) $tahun,
                [2025, 2026]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Tahun gaji hanya boleh 2025 atau 2026!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Validasi nominal
        if (
            !is_numeric($gajiPokok) ||
            !is_numeric($tunjangan) ||
            !is_numeric($potongan)
        ) {
            session()->setFlashdata(
                'error',
                'Gaji pokok, tunjangan, dan potongan harus berupa angka!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        if (
            (float) $gajiPokok < 0 ||
            (float) $tunjangan < 0 ||
            (float) $potongan < 0
        ) {
            session()->setFlashdata(
                'error',
                'Nominal gaji tidak boleh negatif!'
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
                $status,
                [
                    'Sudah Dibayar',
                    'Belum Dibayar'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'Status gaji tidak valid!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Cek duplikat
        $cek = $this->gajiModel
            ->where(
                'nip_asn',
                $nip
            )
            ->where(
                'bulan_gaji',
                (int) $bulan
            )
            ->where(
                'tahun_gaji',
                (int) $tahun
            )
            ->where(
                'is_delete_gaji',
                '0'
            )
            ->where(
                'id_gaji !=',
                $dataGaji['id_gaji']
            )
            ->first();


        if ($cek) {
            session()->setFlashdata(
                'error',
                'Data gaji untuk bulan dan tahun tersebut sudah ada!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Hitung total
        $totalDiterima =
            (float) $gajiPokok
            +
            (float) $tunjangan
            -
            (float) $potongan;


        // Update
        $this->gajiModel
            ->where(
                'id_gaji',
                $dataGaji['id_gaji']
            )
            ->set([

                'nip_asn' =>
                    $nip,

                'bulan_gaji' =>
                    (int) $bulan,

                'tahun_gaji' =>
                    (int) $tahun,

                'gaji_pokok' =>
                    (float) $gajiPokok,

                'tunjangan' =>
                    (float) $tunjangan,

                'potongan' =>
                    (float) $potongan,

                'total_diterima' =>
                    $totalDiterima,

                'status_gaji' =>
                    $status,

                'updated_at' =>
                    date('Y-m-d H:i:s')

            ])
            ->update();


        session()->setFlashdata(
            'success',
            'Data gaji berhasil diperbarui!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-gaji'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // HAPUS DATA GAJI
    // =========================================================
    public function hapus($hash)
    {
        // Cek login
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


        // Cari data
        $dataGaji = $this->gajiModel
            ->where(
                'SHA1(id_gaji)',
                $hash
            )
            ->first();


        if (!$dataGaji) {
            session()->setFlashdata(
                'error',
                'Data gaji tidak ditemukan!'
            );

            ?>
            <script>
                document.location =
                    "<?= base_url('admin/master-data-gaji'); ?>";
            </script>
            <?php
            return;
        }


        // Soft delete
        $this->gajiModel
            ->where(
                'id_gaji',
                $dataGaji['id_gaji']
            )
            ->set([

                'is_delete_gaji' =>
                    '1',

                'updated_at' =>
                    date('Y-m-d H:i:s')

            ])
            ->update();


        session()->setFlashdata(
            'success',
            'Data gaji berhasil dihapus!'
        );

        ?>

        <script>
            document.location =
                "<?= base_url('admin/master-data-gaji'); ?>";
        </script>

        <?php
    }


    // =========================================================
    // FORM IMPORT EXCEL
    // =========================================================
    public function import()
    {
        // Cek login
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


        // Header
        echo view(
            'Backend/Admin/Template/header'
        );


        // View import
        echo view(
            'Backend/Admin/Gaji/import_gaji'
        );


        // Footer
        echo view(
            'Backend/Admin/Template/footer'
        );
    }


    // =========================================================
    // PROSES IMPORT EXCEL
    // =========================================================
    public function proses_import()
    {
        // Cek login
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


        // Ambil file
        $file = $this->request
            ->getFile('file_excel');


        // Validasi file
        if (
            !$file ||
            !$file->isValid()
        ) {
            session()->setFlashdata(
                'error',
                'File Excel belum dipilih atau tidak valid!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        // Extension
        $extension = strtolower(
            $file->getClientExtension()
        );


        if (
            !in_array(
                $extension,
                [
                    'xlsx',
                    'xls'
                ]
            )
        ) {
            session()->setFlashdata(
                'error',
                'File harus berformat XLSX atau XLS!'
            );

            ?>
            <script>
                history.go(-1);
            </script>
            <?php
            return;
        }


        try {

            // Baca Excel
            $spreadsheet = IOFactory::load(
                $file->getTempName()
            );

            $sheet = $spreadsheet
                ->getActiveSheet();

            $rows = $sheet->toArray(
                null,
                true,
                true,
                true
            );


            // Cek data
            if (
                count($rows) <= 1
            ) {
                session()->setFlashdata(
                    'error',
                    'Data Excel kosong!'
                );

                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }

            // Header Excel
            $header = $rows[1];


            $headerA = strtolower(
                trim(
                    (string) ($header['A'] ?? '')
                )
            );

            $headerB = strtolower(
                trim(
                    (string) ($header['B'] ?? '')
                )
            );

            $headerC = strtolower(
                trim(
                    (string) ($header['C'] ?? '')
                )
            );

            $headerD = strtolower(
                trim(
                    (string) ($header['D'] ?? '')
                )
            );

            $headerE = strtolower(
                trim(
                    (string) ($header['E'] ?? '')
                )
            );

            $headerF = strtolower(
                trim(
                    (string) ($header['F'] ?? '')
                )
            );

            $headerG = strtolower(
                trim(
                    (string) ($header['G'] ?? '')
                )
            );


            // Validasi header
            if (
                $headerA !== 'nip_asn' ||
                $headerB !== 'bulan_gaji' ||
                $headerC !== 'tahun_gaji' ||
                $headerD !== 'gaji_pokok' ||
                $headerE !== 'tunjangan' ||
                $headerF !== 'potongan' ||
                $headerG !== 'status_gaji'
            ) {
                session()->setFlashdata(
                    'error',
                    'Format header Excel tidak sesuai!'
                );

                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
                return;
            }


            $berhasil = 0;
            $gagal = 0;

            $pesanGagal = [];

            $dataDalamExcel = [];


            // Loop Excel
            foreach (
                $rows as $nomorBaris => $row
            ) {

                // Lewati header
                if (
                    $nomorBaris == 1
                ) {
                    continue;
                }


                // Ambil data
                $nip = trim(
                    (string) ($row['A'] ?? '')
                );

                $bulan = trim(
                    (string) ($row['B'] ?? '')
                );

                $tahun = trim(
                    (string) ($row['C'] ?? '')
                );

                $gajiPokok = trim(
                    (string) ($row['D'] ?? '')
                );

                $tunjangan = trim(
                    (string) ($row['E'] ?? '')
                );

                $potongan = trim(
                    (string) ($row['F'] ?? '')
                );

                $status = trim(
                    (string) ($row['G'] ?? '')
                );


                // Lewati baris kosong
                if (
                    $nip === '' &&
                    $bulan === '' &&
                    $tahun === '' &&
                    $gajiPokok === '' &&
                    $tunjangan === '' &&
                    $potongan === '' &&
                    $status === ''
                ) {
                    continue;
                }


                // Validasi wajib
                if (
                    $nip === '' ||
                    $bulan === '' ||
                    $tahun === '' ||
                    $gajiPokok === '' ||
                    $tunjangan === '' ||
                    $potongan === '' ||
                    $status === ''
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: data belum lengkap.";

                    continue;
                }


                // Validasi NIP
                $asn = $this->asnModel
                    ->where(
                        'nip_asn',
                        $nip
                    )
                    ->where(
                        'is_delete_asn',
                        '0'
                    )
                    ->first();


                if (!$asn) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: NIP {$nip} tidak ditemukan.";

                    continue;
                }


                // Validasi bulan
                if (
                    !is_numeric($bulan) ||
                    (int) $bulan < 1 ||
                    (int) $bulan > 12
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: bulan harus 1 sampai 12.";

                    continue;
                }


                // Validasi tahun
                if (
                    !in_array(
                        (int) $tahun,
                        [
                            2025,
                            2026
                        ]
                    )
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: tahun harus 2025 atau 2026.";

                    continue;
                }


                // Validasi nominal
                if (
                    !is_numeric($gajiPokok) ||
                    !is_numeric($tunjangan) ||
                    !is_numeric($potongan)
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: nominal gaji harus berupa angka.";

                    continue;
                }


                // Nominal negatif
                if (
                    (float) $gajiPokok < 0 ||
                    (float) $tunjangan < 0 ||
                    (float) $potongan < 0
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: nominal gaji tidak boleh negatif.";

                    continue;
                }


                // Validasi status
                if (
                    !in_array(
                        $status,
                        [
                            'Sudah Dibayar',
                            'Belum Dibayar'
                        ]
                    )
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: status tidak valid.";

                    continue;
                }


                // Key duplikat
                $key =
                    $nip .
                    '-' .
                    (int) $bulan .
                    '-' .
                    (int) $tahun;


                if (
                    isset(
                        $dataDalamExcel[$key]
                    )
                ) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: data NIP {$nip}, bulan {$bulan}, tahun {$tahun} duplikat dalam Excel.";

                    continue;
                }


                $dataDalamExcel[$key] = true;


                // Cek database
                $cek = $this->gajiModel
                    ->where(
                        'nip_asn',
                        $nip
                    )
                    ->where(
                        'bulan_gaji',
                        (int) $bulan
                    )
                    ->where(
                        'tahun_gaji',
                        (int) $tahun
                    )
                    ->where(
                        'is_delete_gaji',
                        '0'
                    )
                    ->first();


                if ($cek) {
                    $gagal++;

                    $pesanGagal[] =
                        "Baris {$nomorBaris}: data NIP {$nip}, bulan {$bulan}, tahun {$tahun} sudah ada di database.";

                    continue;
                }


                // Hitung total
                $totalDiterima =
                    (float) $gajiPokok
                    +
                    (float) $tunjangan
                    -
                    (float) $potongan;


                // Generate ID
                $idGaji =
                    $this->gajiModel
                        ->generateIdGaji();


                // Simpan
                $this->gajiModel
                    ->insert([

                        'id_gaji' =>
                            $idGaji,

                        'nip_asn' =>
                            $nip,

                        'bulan_gaji' =>
                            (int) $bulan,

                        'tahun_gaji' =>
                            (int) $tahun,

                        'gaji_pokok' =>
                            (float) $gajiPokok,

                        'tunjangan' =>
                            (float) $tunjangan,

                        'potongan' =>
                            (float) $potongan,

                        'total_diterima' =>
                            $totalDiterima,

                        'status_gaji' =>
                            $status,

                        'is_delete_gaji' =>
                            '0',

                        'created_at' =>
                            date('Y-m-d H:i:s'),

                        'updated_at' =>
                            date('Y-m-d H:i:s')
                    ]);


                $berhasil++;
            }


            // Pesan hasil
            $pesan =
                "Import selesai! " .
                "Berhasil: {$berhasil} data. " .
                "Gagal: {$gagal} data.";


            // Detail gagal
            if (
                !empty($pesanGagal)
            ) {
                $pesan .=
                    "\n\nDetail:\n" .
                    implode(
                        "\n",
                        $pesanGagal
                    );
            }


            session()->setFlashdata(
                'success',
                $pesan
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
                "<?= base_url('admin/master-data-gaji'); ?>";
        </script>

        <?php
    }

    public function cek_asn()
    {
        $nip = (string) session()->get('ses_nip');
        $data = [];

        if ($nip !== '') {
            $data = $this->gajiModel
                ->where('nip_asn', $nip)
                ->where('is_delete_gaji', '0')
                ->orderBy('tahun_gaji', 'DESC')
                ->orderBy('bulan_gaji', 'DESC')
                ->findAll();
        }

        echo view('Backend/ASN/Template/header');
        echo view('Backend/ASN/Gaji/cek_gaji', [
            'nip' => $nip,
            'data_gaji' => $data
        ]);
        echo view('Backend/ASN/Template/footer');
    }

}