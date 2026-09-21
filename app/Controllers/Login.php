<?php
namespace App\Controllers;
use App\Models\M_Admin;
use App\Models\AsnModel;

class Login extends BaseController
{
    public function login()
    {
        helper('cookie');
        $remember = get_cookie('remember_admin');
        if ($remember !== null) {
            $admin = (new M_Admin())->getDataAdmin(['username_admin'=>$remember,'is_delete_admin'=>'0'])->getRowArray();
            if ($admin) {
                session()->set(['ses_id'=>$admin['id_admin'],'ses_user'=>$admin['nama_admin'],'ses_role'=>'admin']);
                return redirect()->to(base_url('/admin/dashboard-admin'));
            }
        }
        if (session()->get('ses_id') != '') {
            return session()->get('ses_role') === 'admin'
                ? redirect()->to(base_url('/admin/dashboard-admin'))
                : redirect()->to(base_url('/asn/dashboard'));
        }
        return view('Backend/Login/login');
    }

    public function autentikasi()
    {
        helper('cookie');
        $username=$this->request->getPost('username');
        $password=$this->request->getPost('password');
        $remember=$this->request->getPost('remember');
        if ($username==='' || $password==='') {
            session()->setFlashdata('error','Username/NIP dan Password wajib diisi!');
            return redirect()->back();
        }
        $admin=(new M_Admin())->getDataAdmin(['username_admin'=>$username,'is_delete_admin'=>'0'])->getRowArray();
        if ($admin) {
            if (!password_verify($password,$admin['password_admin'])) {
                session()->setFlashdata('error','Password Tidak Sesuai');
                return redirect()->back();
            }
            session()->set(['ses_id'=>$admin['id_admin'],'ses_user'=>$admin['nama_admin'],'ses_role'=>'admin']);
            if ($remember !== null) set_cookie('remember_admin',$username,2592000); else delete_cookie('remember_admin');
            return redirect()->to(base_url('/admin/dashboard-admin'));
        }
        $asn=(new AsnModel())->where('nip_asn',$username)->where('is_delete_asn','0')->first();
        if ($asn) {
            if (!password_verify($password,$asn['password_asn'])) {
                session()->setFlashdata('error','Password Tidak Sesuai');
                return redirect()->back();
            }
            session()->set(['ses_id'=>$asn['id_asn'],'ses_user'=>$asn['nama_asn'],'ses_nip'=>$asn['nip_asn'],'ses_role'=>'asn']);
            delete_cookie('remember_admin');
            return redirect()->to(base_url('/asn/dashboard'));
        }
        session()->setFlashdata('error','Username atau NIP Tidak Ditemukan');
        return redirect()->back();
    }

    public function logout()
    {
        helper('cookie');
        session()->remove(['ses_id','ses_user','ses_role','ses_nip']);
        delete_cookie('remember_admin');
        session()->setFlashdata('info','Anda telah keluar dari sistem');
        return redirect()->to(base_url('/login'));
    }
}
