<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\AsnModel;
use App\Models\SertifikatModel;

class Admin extends BaseController
{
    // =========================================================
    // LOGIN
    // =========================================================
    public function login()
    {
        helper('cookie');

        // ==========================================
        // AUTO LOGIN ADMIN - REMEMBER ME
        // ==========================================
        $remember_token = get_cookie('remember_admin');

        if ($remember_token !== null) {

            $modelAdmin = new M_Admin();

            $dataUser = $modelAdmin->getDataAdmin([
                'username_admin' => $remember_token,
                'is_delete_admin' => '0'
            ])->getRowArray();

            if ($dataUser) {

                $dataSession = [
                    'ses_id'   => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_role' => 'admin'
                ];

                session()->set($dataSession);

                return redirect()->to(
                    base_url('/admin/dashboard-admin')
                );
            }
        }

        // ==========================================
        // JIKA SUDAH LOGIN
        // ==========================================
        if (session()->get('ses_id') != "") {

            if (session()->get('ses_role') == 'admin') {
                return redirect()->to(
                    base_url('/admin/dashboard-admin')
                );
            }

            if (session()->get('ses_role') == 'asn') {
                return redirect()->to(
                    base_url('/asn/dashboard')
                );
            }
        }

        return view('Backend/Login/login');
    }


    // =========================================================
    // DASHBOARD ADMIN
    // =========================================================
    public function dashboard()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses ke halaman Admin!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // MODEL
        // ==========================================
        $modelAdmin = new M_Admin();
        $modelAsn = new AsnModel();
        $modelSertifikat = new SertifikatModel();

        // ==========================================
        // TOTAL DATA
        // ==========================================
        $totalAdmin = $modelAdmin
            ->where('is_delete_admin', '0')
            ->countAllResults();

        $totalAsn = $modelAsn
            ->where('is_delete_asn', '0')
            ->countAllResults();

        $totalSertifikat = $modelSertifikat
            ->where('is_delete_sertifikat', '0')
            ->countAllResults();

        // ==========================================
        // DATA DASHBOARD
        // ==========================================
        $data = [
            'total_admin'       => $totalAdmin,
            'total_asn'         => $totalAsn,
            'total_sertifikat'  => $totalSertifikat
        ];

        // ==========================================
        // TEMPLATE
        // ==========================================
        echo view(
            'Backend/Template/header'
        );

        echo view(
            'Backend/dashboard',
            $data
        );

        echo view(
            'Backend/Template/footer'
        );
    }


    // =========================================================
    // HALAMAN ADMIN
    // =========================================================
    public function admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        echo view(
            'Backend/Template/header'
        );

        echo view(
            'Backend/MasterAdmin/master_data_admin'
        );

        echo view(
            'Backend/Template/footer'
        );
    }


    // =========================================================
    // AUTENTIKASI LOGIN ADMIN + ASN
    // =========================================================
    public function autentikasi()
    {
        helper('cookie');

        $modelAdmin = new M_Admin();
        $modelAsn = new AsnModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // ==========================================
        // VALIDASI INPUT
        // ==========================================
        if ($username == "" || $password == "") {

            session()->setFlashdata(
                'error',
                'Username/NIP dan Password wajib diisi!'
            );

            return redirect()->back();
        }


        // =====================================================
        // 1. CEK ADMIN
        // =====================================================
        $dataAdmin = $modelAdmin->getDataAdmin([
            'username_admin' => $username,
            'is_delete_admin' => '0'
        ])->getRowArray();

        if ($dataAdmin) {

            // Password Admin
            $passwordUser = $dataAdmin['password_admin'];

            // Verifikasi password
            if (!password_verify($password, $passwordUser)) {

                session()->setFlashdata(
                    'error',
                    'Password Tidak Sesuai'
                );

                return redirect()->back();
            }

            // ==========================================
            // SESSION ADMIN
            // ==========================================
            $dataSession = [
                'ses_id'   => $dataAdmin['id_admin'],
                'ses_user' => $dataAdmin['nama_admin'],
                'ses_role' => 'admin'
            ];

            session()->set($dataSession);

            session()->setFlashdata(
                'success',
                'Login Admin Berhasil'
            );

            // ==========================================
            // REMEMBER ME ADMIN
            // ==========================================
            if ($remember != null) {

                set_cookie(
                    'remember_admin',
                    $username,
                    2592000
                );
            }

            return redirect()->to(
                base_url('/admin/dashboard-admin')
            );
        }


        // =====================================================
        // 2. JIKA BUKAN ADMIN → CEK ASN
        // =====================================================
        $dataAsn = $modelAsn
            ->where('nip_asn', $username)
            ->where('is_delete_asn', '0')
            ->first();

        if ($dataAsn) {

            // Password ASN
            $passwordUser = $dataAsn['password_asn'];

            // Verifikasi password
            if (!password_verify($password, $passwordUser)) {

                session()->setFlashdata(
                    'error',
                    'Password Tidak Sesuai'
                );

                return redirect()->back();
            }

            // ==========================================
            // SESSION ASN
            // ==========================================
            $dataSession = [
                'ses_id'   => $dataAsn['id_asn'],
                'ses_user' => $dataAsn['nama_asn'],
                'ses_nip'  => $dataAsn['nip_asn'],
                'ses_role' => 'asn'
            ];

            session()->set($dataSession);

            session()->setFlashdata(
                'success',
                'Login Berhasil'
            );

            // ==========================================
            // ASN TIDAK MENGGUNAKAN REMEMBER ADMIN
            // ==========================================
            delete_cookie('remember_admin');

            return redirect()->to(
                base_url('/asn/dashboard')
            );
        }


        // =====================================================
        // 3. USERNAME / NIP TIDAK DITEMUKAN
        // =====================================================
        session()->setFlashdata(
            'error',
            'Username atau NIP Tidak Ditemukan'
        );

        return redirect()->back();
    }


    // =========================================================
    // LOGOUT
    // =========================================================
    public function logout()
    {
        helper('cookie');

        // ==========================================
        // HAPUS SESSION
        // ==========================================
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_role');
        session()->remove('ses_nip');

        // ==========================================
        // HAPUS REMEMBER ME
        // ==========================================
        delete_cookie('remember_admin');

        session()->setFlashdata(
            'info',
            'Anda telah keluar dari sistem'
        );

        return redirect()->to(
            base_url('/login')
        );
    }


    // =========================================================
    // INPUT ADMIN
    // =========================================================
    public function input_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        echo view(
            'Backend/Template/header'
        );

        echo view(
            'Backend/MasterAdmin/input_admin'
        );

        echo view(
            'Backend/Template/footer'
        );
    }


    // =========================================================
    // SIMPAN DATA ADMIN
    // =========================================================
    public function simpan_data_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        $modelAdmin = new M_Admin();

        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $level = $this->request->getPost('level');

        // ==========================================
        // CEK USERNAME
        // ==========================================
        $cekUsername = $modelAdmin
            ->getDataAdmin([
                'username_admin' => $username
            ])
            ->getNumRows();

        if ($cekUsername > 0) {

            session()->setFlashdata(
                'error',
                'Username sudah digunakan!!'
            );

            return redirect()->back();
        }

        // ==========================================
        // AUTO NUMBER
        // ==========================================
        $hasil = $modelAdmin->autoNumber()->getRowArray();

        if (!$hasil) {

            $id = "ADM001";

        } else {

            $kode = $hasil['id_admin'];

            $noUrut = (int) substr(
                $kode,
                -3
            );

            $noUrut++;

            $id = "ADM" . sprintf(
                "%03s",
                $noUrut
            );
        }

        // ==========================================
        // DATA SIMPAN
        // ==========================================
        $dataSimpan = [
            'id_admin'        => $id,
            'nama_admin'      => $nama,
            'username_admin'  => $username,
            'password_admin'  => password_hash(
                'pass_admin',
                PASSWORD_DEFAULT
            ),
            'is_delete_admin' => '0',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        $modelAdmin->saveDataAdmin(
            $dataSimpan
        );

        session()->setFlashdata(
            'success',
            'Data Admin Berhasil Ditambahkan!!'
        );

        return redirect()->to(
            base_url('/admin/master-data-admin')
        );
    }


    // =========================================================
    // MASTER DATA ADMIN
    // =========================================================
    public function master_data_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        $modelAdmin = new M_Admin();

        $uri = service('uri');

        $pages = $uri->getSegment(2);

        $data = $modelAdmin
            ->getDataAdmin([
                'is_delete_admin' => '0'
            ])
            ->getResultArray();

        $dataUser = [
            'pages'      => $pages,
            'data_admin' => $data
        ];

        echo view(
            'Backend/Template/header'
        );

        echo view(
            'Backend/MasterAdmin/master_data_admin',
            $dataUser
        );

        echo view(
            'Backend/Template/footer'
        );
    }


    // =========================================================
    // EDIT DATA ADMIN
    // =========================================================
    public function edit_data_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        $uri = service('uri');

        $idEdit = $uri->getSegment(3);

        $modelAdmin = new M_Admin();

        $dataAdmin = $modelAdmin
            ->getDataAdmin([
                'sha1(id_admin)' => $idEdit
            ])
            ->getRowArray();

        if (!$dataAdmin) {

            session()->setFlashdata(
                'error',
                'Data Admin tidak ditemukan!'
            );

            return redirect()->to(
                base_url('/admin/master-data-admin')
            );
        }

        session()->set([
            'idUpdate' => $dataAdmin['id_admin']
        ]);

        $page = $uri->getSegment(2);

        $data = [
            'page'       => $page,
            'web_title'  => 'Edit Data Admin',
            'data_admin' => $dataAdmin
        ];

        echo view(
            'Backend/Template/header',
            $data
        );

        echo view(
            'Backend/MasterAdmin/edit_admin',
            $data
        );

        echo view(
            'Backend/Template/footer',
            $data
        );
    }


    // =========================================================
    // UPDATE ADMIN
    // =========================================================
    public function update_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        $modelAdmin = new M_Admin();

        $idUpdate = session()->get('idUpdate');

        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $level = $this->request->getPost('level');

        // ==========================================
        // VALIDASI
        // ==========================================
        if ($nama == "" || $level == "") {

            session()->setFlashdata(
                'error',
                'Isian tidak boleh kosong!!'
            );

            return redirect()->back();
        }

        // ==========================================
        // UPDATE
        // ==========================================
        $dataUpdate = [
            'nama_admin'     => $nama,
            'username_admin' => $username,
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $whereUpdate = [
            'id_admin' => $idUpdate
        ];

        $modelAdmin->updateDataAdmin(
            $dataUpdate,
            $whereUpdate
        );

        session()->remove('idUpdate');

        session()->setFlashdata(
            'success',
            'Data Admin Berhasil Diperbaharui!'
        );

        return redirect()->to(
            base_url('/admin/master-data-admin')
        );
    }


    // =========================================================
    // HAPUS DATA ADMIN
    // =========================================================
    public function hapus_data_admin()
    {
        // ==========================================
        // CEK LOGIN
        // ==========================================
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == ""
        ) {
            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        // ==========================================
        // CEK ROLE
        // ==========================================
        if (session()->get('ses_role') != 'admin') {

            session()->setFlashdata(
                'error',
                'Anda tidak memiliki akses!'
            );

            return redirect()->to(
                base_url('/login')
            );
        }

        $modelAdmin = new M_Admin();

        $uri = service('uri');

        $idHapus = $uri->getSegment(3);

        $whereDelete = [
            'sha1(id_admin)' => $idHapus
        ];

        $modelAdmin
            ->where($whereDelete)
            ->delete();

        session()->setFlashdata(
            'success',
            'Data Admin Berhasil Dihapus!'
        );

        return redirect()->to(
            base_url('/admin/master-data-admin')
        );
    }
}