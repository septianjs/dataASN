<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\AsnModel;

class Login extends BaseController
{
    public function login()
    {
        if (session()->get('ses_id') !== null) {
            return session()->get('ses_role') === 'admin'
                ? redirect()->to(base_url('/admin/dashboard-admin'))
                : redirect()->to(base_url('/asn/dashboard'));
        }

        return view('Backend/Login/login');
    }

    public function autentikasi()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            session()->setFlashdata('error', 'Username/NIP dan Password wajib diisi!');
            return redirect()->back();
        }

        $admin = (new M_Admin())
            ->getDataAdmin([
                'username_admin' => $username,
                'is_delete_admin' => '0'
            ])
            ->getRowArray();

        if ($admin && password_verify($password, $admin['password_admin'])) {
            session()->regenerate(true);
            session()->set([
                'ses_id'   => $admin['id_admin'],
                'ses_user' => $admin['nama_admin'],
                'ses_role' => 'admin'
            ]);

            return redirect()->to(base_url('/admin/dashboard-admin'));
        }

        $asn = (new AsnModel())
            ->where('nip_asn', $username)
            ->where('is_delete_asn', '0')
            ->first();

        if ($asn && password_verify($password, $asn['password_asn'])) {
            session()->regenerate(true);
            session()->set([
                'ses_id'   => $asn['id_asn'],
                'ses_user' => $asn['nama_asn'],
                'ses_nip'  => $asn['nip_asn'],
                'ses_role' => 'asn'
            ]);

            return redirect()->to(base_url('/asn/dashboard'));
        }

        session()->setFlashdata('error', 'Username/NIP atau Password tidak sesuai.');
        return redirect()->back();
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('info', 'Anda telah keluar dari sistem.');
        return redirect()->to(base_url('/login'));
    }
}
