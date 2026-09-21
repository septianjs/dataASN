<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::login');
$routes->get('/Home/coba-parameter/(:alpha)/(:num)/(alphanum)', 'Home:belajar_segment/$1/$2/$3:');

// ===============================
// Router untuk login admin
// ===============================
$routes->get('/admin/login-admin', 'Admin::login');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->post('/admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('/admin/logout', 'admin::logout');

// ===============================
// routes data admin
// ===============================
$routes->get('/admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('/admin/input-admin', 'Admin::input_admin');
$routes->post('/admin/simpan-admin', 'Admin::simpan_data_admin');
$routes->get('/admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('/admin/update-admin', 'Admin::update_admin');
$routes->get('/admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

// ===============================
// routes Data ASN
// ===============================
$routes->get('admin/master-data-asn', 'DataAsn::master_data_asn');
$routes->get('admin/input-asn', 'DataAsn::input_asn');
$routes->post('admin/simpan-data-asn', 'DataAsn::simpan_data_asn');
$routes->post('admin/import-excel-asn', 'DataAsn::import_excel_asn');
$routes->get('admin/edit-data-asn/(:segment)', 'DataAsn::edit_data_asn/$1');
$routes->post('admin/update-data-asn', 'DataAsn::update_data_asn');
$routes->get('admin/hapus-data-asn/(:segment)', 'DataAsn::hapus_data_asn/$1');
$routes->post('admin/hapus-data-asn-terpilih','DataAsn::hapus_data_asn_terpilih');

// ===============================
// Routes Sertifikat
// ===============================
$routes->get('admin/master-data-sertifikat','Sertifikat::master_data_sertifikat');
$routes->get('admin/input-sertifikat','Sertifikat::input_sertifikat');
$routes->post('admin/simpan-data-sertifikat','Sertifikat::simpan_data_sertifikat');
$routes->get('admin/edit-data-sertifikat/(:segment)','Sertifikat::edit_data_sertifikat/$1');
$routes->post('admin/update-data-sertifikat','Sertifikat::update_data_sertifikat');
$routes->get('admin/hapus-data-sertifikat/(:segment)','Sertifikat::hapus_data_sertifikat/$1');
$routes->get('admin/import-sertifikat','Sertifikat::import_excel');
$routes->post('admin/proses-import-sertifikat','Sertifikat::proses_import_excel');
$routes->get('admin/download-template-sertifikat','Sertifikat::download_template_excel');

// ===============================
// ROUTES DATA DIKLAT
// ===============================
$routes->get('admin/master-data-diklat','Diklat::master_data_diklat');
$routes->get('admin/input-diklat','Diklat::input_diklat');
$routes->post('admin/simpan-data-diklat','Diklat::simpan_data_diklat');
$routes->get('admin/edit-data-diklat/(:any)','Diklat::edit_data_diklat/$1');
$routes->post('admin/update-data-diklat','Diklat::update_data_diklat');
$routes->get('admin/hapus-data-diklat/(:any)','Diklat::hapus_data_diklat/$1');

// ===============================
// ROUTES DATA GAJI
// ===============================
$routes->get('admin/master-data-gaji', 'Gaji::index');
$routes->get('admin/input-gaji', 'Gaji::input');
$routes->post('admin/proses-input-gaji', 'Gaji::proses_input');
$routes->get('admin/edit-data-gaji/(:any)', 'Gaji::edit/$1');
$routes->post('admin/proses-edit-gaji/(:any)', 'Gaji::proses_edit/$1');
$routes->get('admin/hapus-data-gaji/(:any)', 'Gaji::hapus/$1');
$routes->get('admin/import-gaji', 'Gaji::import');
$routes->post('admin/proses-import-gaji','Gaji::proses_import');