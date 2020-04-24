angular.module('account.router', [ 'ui.router' ]).config(function($stateProvider, $urlRouterProvider) {
	$urlRouterProvider.otherwise('/account/login');
	$stateProvider
		.state('account', {
			url: '/account',
			templateUrl: './client/views/account/index.html'
		})
		.state('login', {
			url: '/login',
			parent: 'account',
			controller: 'LoginController',
			templateUrl: './client/views/account/sign-in.html'
		});
});
