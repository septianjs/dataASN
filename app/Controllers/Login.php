<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\AsnModel;

class Login extends BaseController
{
    public function login()
    {
        helper('cookie');

        $rememberToken = get_cookie('remember_admin');

        if ($rememberToken !== null) {
            $modelAdmin = new M_Admin();

            $dataUser = $modelAdmin->getDataAdmin([
                'username_admin' => $rememberToken,
                'is_delete_admin' => '0'
            ])->getRowArray();

            if ($dataUser) {
                session()->set([
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_role' => 'admin'
                ]);

                return redirect()->to(base_url('/admin/dashboard-admin'));
            }
        }

        if (session()->get('ses_id') != "") {
            if (session()->get('ses_role') == 'admin') {
                return redirect()->to(base_url('/admin/dashboard-admin'));
            }

            if (session()->get('ses_role') == 'asn') {
                return redirect()->to(base_url('/asn/dashboard'));
            }
        }

        return view('Backend/Login/login');
    }

    public function autentikasi()
    {
        helper('cookie');

        $modelAdmin = new M_Admin();
        $modelAsn = new AsnModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        if ($username == "" || $password == "") {
            session()->setFlashdata('error', 'Username/NIP dan Password wajib diisi!');
            return redirect()->back();
        }

        $dataAdmin = $modelAdmin->getDataAdmin([
            'username_admin' => $username,
            'is_delete_admin' => '0'
        ])->getRowArray();

        if ($dataAdmin) {
            if (!password_verify($password, $dataAdmin['password_admin'])) {
                session()->setFlashdata('error', 'Password Tidak Sesuai');
                return redirect()->back();
            }

            session()->set([
                'ses_id' => $dataAdmin['id_admin'],
                'ses_user' => $dataAdmin['nama_admin'],
                'ses_role' => 'admin'
            ]);

            session()->setFlashdata('success', 'Login Admin Berhasil');

            if ($remember != null) {
                set_cookie('remember_admin', $username, 2592000);
            } else {
                delete_cookie('remember_admin');
            }

            return redirect()->to(base_url('/admin/dashboard-admin'));
        }

        $dataAsn = $modelAsn
            ->where('nip_asn', $username)
            ->where('is_delete_asn', '0')
            ->first();

        if ($dataAsn) {
            if (!password_verify($password, $dataAsn['password_asn'])) {
                session()->setFlashdata('error', 'Password Tidak Sesuai');
                return redirect()->back();
            }

            session()->set([
                'ses_id' => $dataAsn['id_asn'],
                'ses_user' => $dataAsn['nama_asn'],
                'ses_nip' => $dataAsn['nip_asn'],
                'ses_role' => 'asn'
            ]);

            session()->setFlashdata('success', 'Login Berhasil');
            delete_cookie('remember_admin');

            return redirect()->to(base_url('/asn/dashboard'));
        }

        session()->setFlashdata('error', 'Username atau NIP Tidak Ditemukan');
        return redirect()->back();
    }

    public function logout()
    {
        helper('cookie');

        session()->remove(['ses_id', 'ses_user', 'ses_role', 'ses_nip']);
        delete_cookie('remember_admin');

        session()->setFlashdata('info', 'Anda telah keluar dari sistem');

        return redirect()->to(base_url('/login'));
    }
}
