angular.module('admin.router', [ 'ui.router' ]).config(function($stateProvider, $urlRouterProvider) {
	$stateProvider
		.state('admin', {
			url: '/admin',
			controller: 'adminController',
			templateUrl: './client/views/admin/index.html'
		})
		.state('admin-home', {
			url: '/home',
			parent: 'admin',
			controller: 'adminHomeController',
			templateUrl: './client/views/admin/home.html'
		})
		.state('admin-pegawai', {
			url: '/pegawai',
			parent: 'admin',
			controller: 'adminPegawaiController',
			templateUrl: './client/views/admin/pegawai.html'
		})
		.state('admin-siswa', {
			url: '/siswa',
			parent: 'admin',
			controller: 'adminSiswaController',
			templateUrl: './client/views/admin/siswa.html'
		})
		.state('admin-ta', {
			url: '/tahunajaran',
			parent: 'admin',
			controller: 'adminTahunAjaranController',
			templateUrl: './client/views/admin/tahunajaran.html'
		})
		.state('admin-kelulusan', {
			url: '/kelulusan',
			parent: 'admin',
			controller: 'adminKelulusanController',
			templateUrl: './client/views/admin/kelulusan.html'
		});
});
