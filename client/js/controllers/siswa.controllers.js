angular
	.module('siswa.controller', [])
	.controller('siswaController', siswaController)
	.controller('siswaProfileController', siswaProfileController)
	.controller('siswaPengumumanController', siswaPengumumanController)
	.controller('siswaHomeController', siswaHomeController);

function siswaController($scope, $state, AuthService, StorageService) {
	if (!AuthService.userIsLogin()) {
		$state.go('login');
	} else {
		$scope.siswa = StorageService.getObject('user');
	}
}

function siswaHomeController($scope, AuthService, CalonSiswaService) {}

function siswaProfileController($scope, AuthService, CalonSiswaService) {
	if (AuthService.userIsLogin()) {
		AuthService.profile().then((profile) => {
			CalonSiswaService.getById(profile.biodata.idcalonsiswa).then((data) => {
				$scope.model = data;
				console.log(data);
			});
		});
	}
	$scope.print=()=>{
		setTimeout(() => {
			window.print();
		}, 3000);
		
	}
}

function siswaPengumumanController($scope) {}
