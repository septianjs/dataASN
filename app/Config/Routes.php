<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PUBLIC LOGIN
$routes->get('/', 'Login::login');
$routes->get('/login', 'Login::login');
$routes->post('/autentikasi-login', 'Login::autentikasi');
$routes->get('/admin/login-admin', 'Login::login');
$routes->post('/admin/autentikasi-login', 'Login::autentikasi');
$routes->get('/logout', 'Login::logout');
$routes->get('/admin/logout', 'Login::logout');

// ADMIN
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard-admin', 'Admin::dashboard');
    $routes->get('master-data-admin', 'Admin::master_data_admin');
    $routes->get('input-admin', 'Admin::input_admin');
    $routes->post('simpan-admin', 'Admin::simpan_data_admin');
    $routes->get('edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
    $routes->post('update-admin', 'Admin::update_admin');
    $routes->post('hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

    $routes->get('master-data-asn', 'DataAsn::master_data_asn');
    $routes->get('input-asn', 'DataAsn::input_asn');
    $routes->post('simpan-data-asn', 'DataAsn::simpan_data_asn');
    $routes->post('import-excel-asn', 'DataAsn::import_excel_asn');
    $routes->get('edit-data-asn/(:segment)', 'DataAsn::edit_data_asn/$1');
    $routes->post('update-data-asn', 'DataAsn::update_data_asn');
    $routes->post('hapus-data-asn/(:segment)', 'DataAsn::hapus_data_asn/$1');
    $routes->post('hapus-data-asn-terpilih', 'DataAsn::hapus_data_asn_terpilih');

    $routes->get('master-data-sertifikat', 'Sertifikat::master_data_sertifikat');
    $routes->get('input-sertifikat', 'Sertifikat::input_sertifikat');
    $routes->post('simpan-data-sertifikat', 'Sertifikat::simpan_data_sertifikat');
    $routes->get('edit-data-sertifikat/(:segment)', 'Sertifikat::edit_data_sertifikat/$1');
    $routes->post('update-data-sertifikat', 'Sertifikat::update_data_sertifikat');
    $routes->post('hapus-data-sertifikat/(:segment)', 'Sertifikat::hapus_data_sertifikat/$1');

    $routes->get('master-data-diklat', 'Diklat::master_data_diklat');
    $routes->get('input-diklat', 'Diklat::input_diklat');
    $routes->post('simpan-data-diklat', 'Diklat::simpan_data_diklat');
    $routes->get('edit-data-diklat/(:any)', 'Diklat::edit_data_diklat/$1');
    $routes->post('update-data-diklat', 'Diklat::update_data_diklat');
    $routes->post('hapus-data-diklat/(:any)', 'Diklat::hapus_data_diklat/$1');

    $routes->get('master-data-gaji', 'Gaji::index');
    $routes->get('input-gaji', 'Gaji::input');
    $routes->post('proses-input-gaji', 'Gaji::proses_input');
    $routes->get('edit-data-gaji/(:any)', 'Gaji::edit/$1');
    $routes->post('proses-edit-gaji/(:any)', 'Gaji::proses_edit/$1');
    $routes->post('hapus-data-gaji/(:any)', 'Gaji::hapus/$1');
    $routes->get('import-gaji', 'Gaji::import');
    $routes->post('proses-import-gaji', 'Gaji::proses_import');
});

// ASN
$routes->group('asn', ['filter' => 'asn'], static function ($routes) {
    $routes->get('dashboard', 'DataAsn::dashboard_asn');
    $routes->get('data-full', 'DataAsn::data_full');
    $routes->post('cek-sertifikat', 'Sertifikat::cek_asn');
    $routes->post('cek-diklat', 'Diklat::cek_asn');
    $routes->post('cek-gaji', 'Gaji::cek_asn');
});
