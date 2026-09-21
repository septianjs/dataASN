<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\AsnModel;
use App\Models\SertifikatModel;

class Admin extends BaseController
{
    public function login()
    {
        helper('cookie'); // Panggil helper cookie

        // ==========================================
        // LOGIKA AUTO-LOGIN (REMEMBER ME)
        // ==========================================
        $remember_token = get_cookie('remember_admin');
        
        // Jika ada cookie, langsung cek ke database
        if ($remember_token !== null) {
            $modelAdmin = new M_Admin();
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $remember_token, 'is_delete_admin' => '0'])->getRowArray();
            
            if ($dataUser) {
                // Buat session otomatis
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user'=> $dataUser['nama_admin'],
                ];
                session()->set($dataSession);
                
                // Langsung arahkan ke dashboard
                return redirect()->to(base_url('/admin/dashboard-admin'));
            }
        }

        // Jika session sudah ada (sudah login), jangan tampilkan form login lagi
        if (session()->get('ses_id') != "") {
            return redirect()->to(base_url('/admin/dashboard-admin'));
        }

        return view('Backend/Login/login');
    }

    public function dashboard()
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

        // =========================
        // MODEL
        // =========================
        $modelAdmin = new M_Admin();
        $modelAsn = new AsnModel();
        $modelSertifikat = new SertifikatModel();

        // =========================
        // TOTAL
        // =========================
        $totalAdmin = $modelAdmin->where('is_delete_admin', '0')->countAllResults();
        $totalAsn = $modelAsn->where('is_delete_asn', '0')->countAllResults();
        $totalSertifikat = $modelSertifikat->where('is_delete_sertifikat', '0')->countAllResults();

        // =========================
        // DATA DASHBOARD
        // =========================
        $data = [
            'total_admin' => $totalAdmin,
            'total_asn' => $totalAsn,
            'total_sertifikat' => $totalSertifikat
        ];

        // =========================
        // TEMPLATE
        // =========================
        echo view('Backend/Template/header');
        echo view('Backend/dashboard', $data);
        echo view('Backend/Template/footer');
    }

    public function admin()
    {
        if (session()->get('ses_id') == "") {
            session()->setFlashdata('error','silahkan login terlebih dahulu');
            ?>
            <script>
                document.location = "<?=base_url('admin/login-admin');?>";
            </script>
            <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/MasterAdmin/master_data_admin');
            echo view('Backend/Template/footer');
        }
    }

    public function autentikasi() {
        helper('cookie'); // Panggil helper cookie
        $modelAdmin = new M_Admin; 

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember'); // Tangkap nilai Remember Me

        $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
        
        if ($cekUsername == 0){
            session()->setFlashdata('error','Username Tidak Ditemukan');
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        } else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
            $passwordUser = $dataUser['password_admin'];

            $vertifikasiPassword = password_verify($password, $passwordUser);
            if(!$vertifikasiPassword) {
                session()->setFlashdata('error', 'Password Tidak Sesuai');
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
            } else {
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user'=> $dataUser['nama_admin'],
                ];
                session()->set($dataSession);
                
                // Typo diperbaiki: 'succes' menjadi 'success'
                session()->setFlashdata('success', 'Login Berhasil');

                // ==========================================
                // JIKA INGAT SAYA DICENTANG, BUAT COOKIE
                // ==========================================
                if ($remember != null) {
                    // Buat cookie bernama 'remember_admin', isinya username, berlaku selama 30 Hari (2592000 detik)
                    set_cookie('remember_admin', $username, 2592000);
                }

                ?>
                <script>
                    document.location = "<?= base_url('/admin/dashboard-admin');?>";
                </script>
                <?php
            }
        }
    }

    public function logout(){
        helper('cookie'); // Panggil helper cookie

        session()->remove('ses_id');
        session()->remove('ses_user');
        
        // ==========================================
        // HAPUS COOKIE REMEMBER ME SAAT LOGOUT
        // ==========================================
        delete_cookie('remember_admin');

        session()->setFlashdata('info','Anda telah keluar dari sistem');
        ?>
        <script>
            document.location = "<?=base_url('admin/login-admin');?>";
        </script>
        <?php
    }

    public function input_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/MasterAdmin/input_admin');
            echo view('Backend/Template/footer');
        }
    }
    
    public function simpan_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
        } else {
            $modelAdmin = new M_Admin; 
    
            $nama     = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level    = $this->request->getPost('level');
    
            $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
            if($cekUsername > 0){
                session()->setFlashdata('error','Username sudah digunakan!!');
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
            } else {
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if(!$hasil){
                    $id = "ADM001";
                } else {
                    $kode   = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "ADM".sprintf("%03s", $noUrut);
                }
    
                $dataSimpan = [
                    'id_admin'       => $id,
                    'nama_admin'     => $nama,
                    'username_admin' => $username,
                    'password_admin' => password_hash('pass_admin', PASSWORD_DEFAULT),
                    'is_delete_admin'=> '0',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s')
                ];
    
                $modelAdmin->saveDataAdmin($dataSimpan);
                session()->setFlashdata('success', 'Data Admin Berhasil Ditambahkan!!');
                ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-admin'); ?>";
                </script>
                <?php
            }
        }
    }

    public function master_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
        } else {
            $modelAdmin = new M_Admin; 

            $uri = service('uri');
            $pages = $uri->getSegment(2);
            $data = $modelAdmin->getDataAdmin(['is_delete_admin'=>'0',])->getResultArray();
            
            $dataUser =[
                'pages' =>$pages,
                'data_admin'=>$data
            ];

            echo view('Backend/Template/header');
            echo view('Backend/MasterAdmin/master_data_admin', $dataUser);
            echo view('Backend/Template/footer');
        }
    }

    public function edit_data_admin()
    {
        $uri = service('uri');
        $idEdit = $uri->getSegment(3);
        $modelAdmin = new M_Admin;
        
        $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataAdmin['id_admin']]);

        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Admin";
        $data['data_admin'] = $dataAdmin; 

        echo view('Backend/Template/header', $data);
        echo view('Backend/MasterAdmin/edit_admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_admin()
    {
        $modelAdmin = new M_Admin;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $level = $this->request->getPost('level');

        if ($nama == "" or $level == "") {
            session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        } else {
            $dataUpdate = [
                'nama_admin' => $nama,
                'username_admin' => $username,
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $whereUpdate = ['id_admin' => $idUpdate];

            $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('success', 'Data Admin Berhasil Diperbaharui!');
            ?>
            <script>
                document.location = "<?= base_url('admin/master-data-admin'); ?>";
            </script>
            <?php
        }
    }

    public function hapus_data_admin()
    {
        $modelAdmin = new M_Admin;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $whereDelete = [
            'sha1(id_admin)' => $idHapus
        ];

        $modelAdmin->where($whereDelete)->delete();

        session()->setFlashdata(
            'success',
            'Data Admin Berhasil Dihapus!'
        );

        ?>
        <script>
            document.location =
                "<?= base_url('admin/master-data-admin'); ?>";
        </script>
        <?php
    }

}