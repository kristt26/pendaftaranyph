<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['API'] = 'Rest_server';

// User
$route['api/users']['post'] = 'Users/login';

// Siswa
$route['api/calonsiswa']['get'] = 'CalonSiswa/GetSiswa';
$route['api/calonsiswa']['post'] = 'CalonSiswa/Simpan';
$route['api/calonsiswa']['put'] = 'CalonSiswa/ubah';
// $route['api/siswa/:num']['delete'] = 'Siswa/Hapus';


// orangtua
$route['api/orangtua']['get'] = 'OrangTua/Ambil';
$route['api/orangtua']['post'] = 'OrangTua/Simpan';
$route['api/orangtua']['put'] = 'OrangTua/ubah';


// Beasiswa
$route['api/beasiswa']['get'] = 'Beasiswa/Ambil';
$route['api/beasiswa']['post'] = 'Beasiswa/Simpan';
$route['api/beasiswa']['put'] = 'Beasiswa/ubah';

// kesejahteraan
$route['api/kesejahteraan']['get'] = 'Kesejahteraan/Ambil';
$route['api/kesejahteraan']['post'] = 'Kesejahteraan/Simpan';
$route['api/kesejahteraan']['put'] = 'Kesejahteraan/ubah';

// prestasi
$route['api/prestasi']['get'] = 'Prestasi/Ambil';
$route['api/prestasi']['post'] = 'Prestasi/Simpan';
$route['api/prestasi']['put'] = 'Prestasi/ubah';


$route['api/pegawai']['get'] = 'Pegawai/Ambil';
$route['api/pegawai']['post'] = 'Pegawai/Simpan';
$route['api/pegawai']['put'] = 'Pegawai/ubah';
$route['api/pegawai/:num']['delete'] = 'SiPegawaiswa/Hapus';

// Tahun Ajaran
$route['api/tahunajaran']['get'] = 'TahunAjaran/Ambil';
$route['api/tahunajaran']['post'] = 'TahunAjaran/Simpan';
$route['api/tahunajaran']['put'] = 'TahunAjaran/ubah';
$route['api/tahunajaran/:num']['delete'] = 'TahunAjaran/Hapus';

// berkas
$route['api/berkas']['get'] = 'DetailPersyaratan/Ambil';
$route['api/berkas']['post'] = 'DetailPersyaratan/simpan';

// Tahun Ajaran
$route['api/content']['get'] = 'Content/Ambil';
$route['api/content']['post'] = 'Content/Simpan';
$route['api/content']['put'] = 'Content/ubah';
$route['api/content/:num']['delete'] = 'Content/Hapus';

// Persyaratan
$route['api/persyaratan']['get'] = 'Persyaratan/Ambil';
$route['api/persyaratan']['post'] = 'Persyaratan/Simpan';
$route['api/persyaratan']['put'] = 'Persyaratan/ubah';
$route['api/persyaratan/:num']['delete'] = 'Persyaratan/Hapus';

/**
 * Nilai
 */

$route['api/nilai']['post'] = 'Nilai/simpan';
