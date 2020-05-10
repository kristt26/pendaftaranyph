angular
	.module('guest.controller', [])
	.controller('guestController', guestController)
	.controller('guestHomeController', guestHomeController)
	.controller('informasiController', informasiController)
	.controller('pengumumanController', pengumumanController)
	.controller('daftarController', daftarController)
	.controller('detailController', detailController);

function guestController($scope, $state, AuthService, TahunAjaranService, CalonSiswaService) {}

function guestHomeController($scope, ContentService, $sce, TahunAjaranService, CalonSiswaService, AuthService) {
	$scope.daftarComplete = false;
	$scope.showMenu = false;

	setTimeout(() => {
		$scope.showMenu = true;
	}, 3000);

	ContentService.get().then((result) => {
		$scope.pengumuman = result.filter((x) => x.type == 'pengumuman' && x.publish);
		$scope.informasi = result.filter((x) => x.type == 'informasi' && x.publish);
		var info = angular.copy(result[0]);
		info.content = $sce.trustAsHtml(info.content);
		$scope.selectedContent = info;

		TahunAjaranService.get().then((result) => {
			$scope.taActive = result.find((x) => x.status);
			if (AuthService.userIsLogin()) {
				AuthService.profile().then((profile) => {
					CalonSiswaService.getById(profile.biodata.idcalonsiswa).then((x) => {
						if (!x.detailpersyaratan || x.detailpersyaratan.length <= 0) {
							$state.go('guest-daftar');
						} else {
							$scope.daftarComplete = true;
						}
						$scope.showMenu = true;
					});
				});
			}
		});
	});
}

function informasiController($scope, $state, helperServices, ContentService) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	ContentService.get().then((result) => {
		$scope.helper.IsBusy = false;
		$scope.source = result.filter((x) => x.type == 'informasi' && x.publish);
	});
}

function pengumumanController($scope, $state, helperServices, ContentService) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	ContentService.get().then((result) => {
		$scope.helper.IsBusy = false;
		$scope.source = result.filter((x) => x.type == 'pengumuman' && x.publish);
	});
}

function daftarController(
	$scope,
	$state,
	CalonSiswaService,
	helperServices,
	TahunAjaranService,
	AuthService,
	PersyaratanService
) {
	$scope.helper = helperServices;
	$scope.steppers = [
		{ selected: true, idstepper: 1, name: 'Biodata', complete: false },
		{ selected: false, idstepper: 2, name: 'Orang Tua', complete: false },
		{ selected: false, idstepper: 3, name: 'Nilai', complete: false },
		{ selected: false, idstepper: 4, name: 'Prestasi', complete: false },
		{ selected: false, idstepper: 5, name: 'Kesejahteraan', complete: false },
		{ selected: false, idstepper: 6, name: 'Beasiswa', complete: false },
		{ selected: false, idstepper: 7, name: 'Berkas', complete: false },
		{ selected: false, idstepper: 8, name: 'Selesai', complete: false }
	];

	TahunAjaranService.get().then((result) => {
		$scope.taActive = result.find((x) => x.status);
		if (AuthService.userIsLogin()) {
			$scope.showContent = false;
			$scope.helper.IsBusy = true;
			AuthService.profile().then((profile) => {
				CalonSiswaService.getById(profile.biodata.idcalonsiswa).then((x) => {
					if (!x.orangtua) x.orangtua = [];
					if (!x.orangtua.find((ortu) => ortu.jenisorangtua == 'Ayah'))
						x.orangtua.push({
							idorangtua: 0,
							idcalonsiswa: x.idcalonsiswa,
							kebutuhankhusus: false,
							jenisorangtua: 'Ayah'
						});
					if (!x.orangtua.find((ortu) => ortu.jenisorangtua == 'Ibu'))
						x.orangtua.push({
							idorangtua: 0,
							idcalonsiswa: x.idcalonsiswa,
							kebutuhankhusus: false,
							jenisorangtua: 'Ibu'
						});
					if (!x.orangtua.find((ortu) => ortu.jenisorangtua == 'Wali'))
						x.orangtua.push({
							idorangtua: 0,
							idcalonsiswa: x.idcalonsiswa,
							kebutuhankhusus: false,
							jenisorangtua: 'Wali'
						});
					$scope.siswa = x;
					$scope.helper.IsBusy = false;

					PersyaratanService.get().then((persyaratan) => {
						var step = $scope.steppers.find((x) => x.idstepper == 6);
						step.complete = true;
						persyaratan.forEach((item) => {
							var data = $scope.siswa.detailpersyaratan.find(
								(x) => x.idpersyaratan == item.idpersyaratan
							);
							if (!data) {
								step.complete = false;
								$scope.siswa.detailpersyaratan.push({
									iddetailpersyaratan: 0,
									idcalonsiswa: x.idcalonsiswa,
									idpersyaratan: item.idpersyaratan,
									berkas: null,
									persyaratan: item.persyaratan
								});
							} else {
								data.persyaratan = item.persyaratan;
							}
						});
						$scope.showContent = true;
					});
					setTimeout(() => {
						setLastSteper(x);
					}, 3000);
				});
			});
		} else {
			$scope.siswa = CalonSiswaService.siswa;
			$scope.siswa.orangtua = [];
			$scope.siswa.prestasi = [];
			$scope.siswa.kesejahteraan = [];
			$scope.siswa.orangtua.push({ idorangtua: 0, kebutuhankhusus: false, jenisorangtua: 'Ayah' });
			$scope.siswa.orangtua.push({ idorangtua: 0, kebutuhankhusus: false, jenisorangtua: 'Ibu' });
			$scope.siswa.orangtua.push({ idorangtua: 0, kebutuhankhusus: false, jenisorangtua: 'Wali' });
			$scope.showContent = true;
		}
	});

	$scope.select = (id) => {
		$scope.steppers.forEach((element) => {
			element.selected = false;
			if (element.idstepper == id) {
				element.selected = true;
				$scope.selectedSteperText = element.name;
			}
		});
	};

	$scope.addPrestasi = (model) => {
		if (!$scope.siswa.prestasi) {
			$scope.siswa.prestasi = [];
		}
		if (!model.idprestasi || model.idprestasi <= 0) {
			$scope.siswa.prestasi.push(model);
		}
	};

	$scope.selectItem = (model) => {
		$scope.model = model;
	};

	$scope.addKesejahteraan = (model) => {
		if (!$scope.siswa.kesejahteraan) {
			$scope.siswa.kesejahteraan = [];
		}
		if (!model.idkesejahteraan || model.idkesejahteraan <= 0) {
			$scope.siswa.kesejahteraan.push(model);
		}
	};

	$scope.addBeasiswa = (model) => {
		if (!$scope.siswa.beasiswa) {
			$scope.siswa.beasiswa = [];
		}
		if (!model.idbeasiswa || model.idbeasiswa <= 0) {
			$scope.siswa.beasiswa.push(model);
		}
	};

	$scope.save = (idstepper, model) => {
		$scope.helper.IsBusy = true;

		switch (idstepper) {
			case 1:
				model.idtahunajaran = $scope.taActive.idtahunajaran;
				CalonSiswaService.saveCalonSiswa(model).then((x) => {
					next(idstepper);
					$scope.helper.IsBusy = false;
				});
				break;
			case 2:
				CalonSiswaService.saveOrangTua(model).then((x) => {
					next(idstepper);
					$scope.helper.IsBusy = false;
				});

				break;

			case 3:
				CalonSiswaService.addPrestasi(model).then((x) => {
					next(idstepper);
					$scope.helper.IsBusy = false;
				});
				break;
			case 4:
				CalonSiswaService.addKesejahteraan(model).then((x) => {
					next(idstepper);
					$scope.helper.IsBusy = false;
				});
				break;

			case 5:
				CalonSiswaService.addBeasiswa(model).then((x) => {
					next(idstepper);
					$scope.helper.IsBusy = false;
				});
				break;

			default:
				break;
		}
	};

	function next(id) {
		$scope.steppers.forEach((element) => {
			element.selected = false;
			if (element.idstepper == id) {
				element.complete = true;
				element.selected = false;
			}
			if (element.idstepper == id + 1) {
				element.selected = true;
				$scope.selectedSteperText = element.name;
			}
		});
		setTimeout(() => {
			var tabName = '#tab' + (id + 1).toString();
			$('#myTab a[data-target="' + tabName + '"]').tab('show');
		}, 300);
	}

	function setLastSteper(x) {
		var nextSteper = 0;
		for (let index = 0; index < $scope.steppers.length; index++) {
			var step = $scope.steppers[index];

			switch (step.idstepper) {
				case 1:
					nextSteper = changeStepper(x.idcalonsiswa, step.idstepper);
					break;
				case 2:
					nextSteper = changeStepper(x.orangtua && x.orangtua.length > 0, step.idstepper);
					break;
				case 3:
					nextSteper = changeStepper(x.nilai || x.nilai.idnilai > 0, step.idstepper);
					break;
				case 4:
					nextSteper = changeStepper(x.prestasi && x.prestasi.length > 0, step.idstepper);
					break;
				case 5:
					nextSteper = changeStepper(x.kesejahteraan && x.kesejahteraan.length > 0, step.idstepper);
					break;
				case 6:
					nextSteper = changeStepper(x.beasiswa && x.beasiswa.length > 0, step.idstepper);
					break;
				case 7:
					nextSteper = changeStepper(x.detailpersyaratan && x.detailpersyaratan.length > 0, step.idstepper);
					break;
				default:
					nextSteper = 7;
					break;
			}

			if (nextSteper) {
				next(nextSteper);
				break;
			}
		}

		function changeStepper(isTure, steperId) {
			if (isTure) {
				step.complete = true;
				step.selected = false;
				return 0;
			} else {
				return steperId;
			}
		}
	}
}

function detailController($scope, $stateParams, $sce, ContentService) {
	ContentService.getById($stateParams.id).then((result) => {
		var info = angular.copy(result);
		info.content = $sce.trustAsHtml(info.content);
		$scope.model = info;
	});
}
