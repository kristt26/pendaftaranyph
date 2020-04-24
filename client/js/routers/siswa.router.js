angular.module('siswa.router', [ 'ui.router' ]).config(function($stateProvider, $urlRouterProvider) {
	$stateProvider
		.state('siswa', {
			url: '/siswa',
			controller: 'siswaController',
			templateUrl: './client/views/siswa/index.html'
		})
		.state('siswa-home', {
			url: '/home',
			parent: 'siswa',
			controller: 'siswaHomeController',
			templateUrl: './client/views/siswa/home.html'
		});
});
