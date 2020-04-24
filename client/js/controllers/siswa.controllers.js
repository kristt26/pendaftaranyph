angular.module('siswa.controller', []).controller('siswaController', siswaController);

function siswaController($scope, $state, AuthService, StorageService) {
	if (!AuthService.userIsLogin()) {
		$state.go('login');
	} else {
		$scope.siswa = StorageService.getObject('user');
	}
}
