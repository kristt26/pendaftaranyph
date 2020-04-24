angular.module('siswa.router', [ 'ui.router' ]).config(function($stateProvider, $urlRouterProvider) {
	$stateProvider
		.state('siswa-home', {
			url: '/siswa',
			controller: 'siswaController',
			templateUrl: './client/views/siswa/index.html'
		})
		.state('siswa-home-home', {
			url: '/home',
			parent: 'siswa',
			controller: 'adminHomeController',
			templateUrl: './client/views/admin/home.html'
		});
});
