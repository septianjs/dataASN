<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\AsnModel;
use App\Models\SertifikatModel;

class Admin extends BaseController
{
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
            'Backend/Admin/Template/header'
        );

        echo view(
            'Backend/Admin/Dashboard/dashboard_admin',
            $data
        );

        echo view(
            'Backend/Admin/Template/footer'
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
            'Backend/Admin/Template/header'
        );

        echo view(
            'Backend/Admin/DataAdmin/data_admin'
        );

        echo view(
            'Backend/Admin/Template/footer'
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
            'Backend/Admin/Template/header'
        );

        echo view(
            'Backend/Admin/DataAdmin/input_admin'
        );

        echo view(
            'Backend/Admin/Template/footer'
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
            'Backend/Admin/Template/header'
        );

        echo view(
            'Backend/Admin/DataAdmin/data_admin',
            $dataUser
        );

        echo view(
            'Backend/Admin/Template/footer'
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
            'Backend/Admin/Template/header',
            $data
        );

        echo view(
            'Backend/Admin/DataAdmin/edit_admin',
            $data
        );

        echo view(
            'Backend/Admin/Template/footer',
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