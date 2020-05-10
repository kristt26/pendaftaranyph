angular
	.module('guest.controller', [])
	.controller('guestController', guestController)
	.controller('guestHomeController', guestHomeController)
	.controller('informasiController', informasiController)
	.controller('pengumumanController', pengumumanController)
	.controller('daftarController', daftarController)
	.controller('detailController', detailController);

function guestController($scope, $state, AuthService, TahunAjaranService, CalonSiswaService) {}

function detailController($scope, $stateParams, $sce, ContentService) {
	ContentService.getById($stateParams.id).then((result) => {
		var info = angular.copy(result);
		info.content = $sce.trustAsHtml(info.content);
		$scope.model = info;
	});
}

function guestHomeController($scope, ContentService, $sce, $state, TahunAjaranService, CalonSiswaService, AuthService) {
	$scope.daftarComplete = false;
	$scope.showMenu = false;

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
					if (profile.biodata.statusselesai != '0') $state.go('guest-daftar');
					else {
						$scope.daftarComplete = true;
					}
				});
				$scope.showMenu = true;
			} else {
				$scope.showMenu = true;
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
	message,
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
		if (!model.edit) {
			$scope.siswa.prestasi.push(model);
		}
		model = {};
	};
	$scope.deletePrestasi = (model) => {
		var index = $scope.siswa.prestasi.indexOf(model);
		$scope.siswa.prestasi.splice(index, 1);
	};

	$scope.selectItem = (model) => {
		$scope.model = model;
		$scope.model.edit = true;
	};

	$scope.addKesejahteraan = (model) => {
		if (!$scope.siswa.kesejahteraan) {
			$scope.siswa.kesejahteraan = [];
		}
		if (!model.edit) {
			$scope.siswa.kesejahteraan.push(model);
		}
		model = {};
	};
	$scope.deleteKesejahteraan = (model) => {
		var index = $scope.siswa.kesejahteraan.indexOf(model);
		$scope.siswa.kesejahteraan.splice(index, 1);
	};

	$scope.addBeasiswa = (model) => {
		if (!$scope.siswa.beasiswa) {
			$scope.siswa.beasiswa = [];
		}
		if (!model.edit) {
			$scope.siswa.beasiswa.push(model);
		}
		model = {};
	};

	$scope.deleteBeasiswa = (model) => {
		var index = $scope.siswa.beasiswa.indexOf(model);
		$scope.siswa.beasiswa.splice(index, 1);
	};

	$scope.save = (idstepper, model) => {
		$scope.helper.IsBusy = true;

		switch (idstepper) {
			case 1:
				model.idtahunajaran = $scope.taActive.idtahunajaran;
				if (biodataValid(model))
					CalonSiswaService.saveCalonSiswa(model).then((x) => {
						next(idstepper);
					});
				break;
			case 2:
				CalonSiswaService.saveOrangTua(model).then((x) => {
					next(idstepper);
				});

				break;

			case 3:
				CalonSiswaService.saveNilai(model).then((x) => {
					next(idstepper);
				});
				break;
			case 4:
				if (model.length > 0) {
					CalonSiswaService.addPrestasi(model).then((x) => {
						next(idstepper);
					});
				} else {
					next(idstepper);
				}
				break;
			case 5:
				if (model.length > 0) {
					CalonSiswaService.addKesejahteraan(model).then((x) => {
						next(idstepper);
					});
				} else {
					next(idstepper);
				}
				break;

			case 6:
				if (model.length > 0) {
					CalonSiswaService.addBeasiswa(model).then((x) => {
						next(idstepper);
					});
				} else {
					next(idstepper);
				}
				break;

			case 7:
				var completePersyaratan = true;
				model.forEach((element) => {
					if (!element.berkas) completePersyaratan = false;
				});

				if (completePersyaratan) {
					next(idstepper);
				} else {
					message.error('Lengkapi Berkas Persyaratan');
					$scope.helper.IsBusy = false;
				}
				break;

			case 8:
				if (model) {
					CalonSiswaService.finish(model.idcalonsiswa).then((x) => {
						$state.go('siswa-home');
					});
				}
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
		$scope.helper.IsBusy = false;
		setTimeout(() => {
			$scope.showContent = true;
			var tabName = '#tab' + (id + 1).toString();
			$scope.$apply((x) => {
				//$(tabName).tab('show');
			});
			$('#myTab button[data-target="' + tabName + '"]').tab('show');
		}, 2000);
	}

	function setLastSteper(x) {
		var nextSteper = 0;
		for (let index = 0; index < $scope.steppers.length; index++) {
			var step = $scope.steppers[index];

			switch (step.idstepper) {
				case 1:
					nextSteper = changeStepper(x.idcalonsiswa, step);
					break;
				case 2:
					var foundOrtu = false;
					x.orangtua.forEach((ortu) => {
						if (ortu.idorangtua > 0) foundOrtu = true;
					});
					nextSteper = changeStepper(foundOrtu, step);
					break;
				case 3:
					nextSteper = changeStepper(x.nilai || x.nilai.idnilai > 0, step);
					break;
				case 4:
					nextSteper = changeStepper(x.prestasi && x.prestasi.length > 0, step);
					break;
				case 5:
					nextSteper = changeStepper(x.kesejahteraan && x.kesejahteraan.length > 0, step);
					break;
				case 6:
					nextSteper = changeStepper(x.beasiswa && x.beasiswa.length > 0, step);
					break;
				case 7:
					nextSteper = changeStepper(x.detailpersyaratan && x.detailpersyaratan.length > 0, step);
					break;
				default:
					step.complete = true;
					step.selected = false;
					nextSteper = 8;
					break;
			}

			if (nextSteper) {
				next(nextSteper - 1);
				break;
			}
		}

		function changeStepper(isTure, step) {
			if (isTure) {
				step.complete = true;
				step.selected = false;
				return 0;
			} else {
				return step.idstepper;
			}
		}
	}

	//validation

	function biodataValid(model) {
		var valid = true;

		if (model.password !== model.confirm) {
			message.error('Password Tidak Sama');
			valid = false;
		}

		return valid;
	}
}
