angular
	.module('account.controller', [])
	.controller('LoginController', LoginController)
	.controller('registrasiController', registrasiController);

function LoginController($scope, $state, AuthService) {
	$scope.login = function(user) {
		AuthService.login(user).then((x) => {
			if (x.role == 'calonsiswa') $state.go('guest' + '-home');
			else $state.go(x.role + '-home');
		});
	};
}

function registrasiController($scope, $state, AuthService) {}
