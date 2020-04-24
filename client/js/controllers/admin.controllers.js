angular
	.module('admin.controller', [])
	.controller('adminController', adminController)
	.controller('adminSiswaController', adminSiswaController)
	.controller('adminPegawaiController', adminPegawaiController)
	.controller('adminKelulusanController', adminKelulusanController)
	.controller('adminTahunAjaranController', adminTahunAjaranController)
	.controller('adminHomeController', adminHomeController);

function adminController($scope, $state, AuthService) {
	if (!AuthService.userIsLogin()) {
		$state.go('login');
	}
}
function adminSiswaController($scope, message, SiswaService, helperServices) {
	$scope.helper = helperServices;
	SiswaService.get().then((result) => {
		$scope.source = result;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.model.tanggallahir = new Date(model.tanggallahir);
		$scope.title = 'Edit Siswa';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idsiswa) {
			SiswaService.put(model).then(
				(x) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		} else {
			SiswaService.post(model).then(
				(result) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		}
	};

	$scope.delete = (item) => {
		message.dialog().then(
			(x) => {
				SiswaService.delete(item.idsiswa).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}
function adminPegawaiController($scope, PegawaiService, message, PegawaiService, helperServices) {
	$scope.helper = helperServices;
	PegawaiService.get().then((result) => {
		$scope.source = result;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.title = 'Edit Pegawai';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idpegawai) {
			PegawaiService.put(model).then(
				(x) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		} else {
			PegawaiService.post(model).then(
				(result) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		}
	};

	$scope.delete = (item) => {
		message.dialog().then(
			(x) => {
				PegawaiService.delete(item.idpegawai).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}
function adminKelulusanController($scope, KelulusanService, message, helperServices, SiswaService, TahunAjaranService) {
	$scope.helper = helperServices;
	TahunAjaranService.get().then((ta) => {
		$scope.tahuns = ta;
		$scope.selectedTa = ta.find((x) => x.status);
		$scope.ta = angular.copy($scope.selectedTa);
		SiswaService.get().then((siswas) => {
			$scope.source = siswas;
		});
	});

	$scope.edit = (model) => {
		$scope.model = { siswa: angular.copy(model) };
		$scope.title = 'Edit Kelulusan';
	};
	$scope.save = (model) => {
		if (!model.siswa.idtahunajaran) {
			model.siswa.idtahunajaran = $scope.selectedTa.idtahunajaran;
		}
		$scope.helper.IsBusy = true;
		KelulusanService.post(model.siswa).then(
			(result) => {
				$scope.helper.IsBusy = false;
				var data = $scope.source.find((x) => x.idsiswa == model.siswa.idsiswa);
				if (data) {
					data.idkelulusan = result.idkelulusan;
					data.idtahunajaran = result.idtahunajaran;
					data.idsiswa = result.idsiswa;
					data.nilaisekolah = result.nilaisekolah;
					data.nilaiun = result.nilaiun;
					data.nilaiakhir = result.nilaiakhir;
					data.status = result.status;
					data.Berkas = result.Berkas;
				}

				message.info('Data Berhasil Disimpan');
			},
			(err) => {
				$scope.helper.IsBusy = false;
				message.error('Data Gagal Disimpan');
			}
		);
	};

	$scope.delete = (item) => {
		message.dialog().then(
			(x) => {
				KelulusanService.delete(item.idkelulusan).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}
function adminTahunAjaranController($scope, message, TahunAjaranService, helperServices) {
	$scope.helper = helperServices;
	TahunAjaranService.get().then((result) => {
		$scope.source = result;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.model.tanggallahir = new Date(model.tanggallahir);
		$scope.title = 'Edit Pegawai';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idtahunajaran) {
			TahunAjaranService.put(model).then(
				(x) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		} else {
			TahunAjaranService.post(model).then(
				(result) => {
					$scope.helper.IsBusy = false;
					message.info('Data Berhasil Disimpan');
				},
				(err) => {
					$scope.helper.IsBusy = false;
					message.error('Data Gagal Disimpan');
				}
			);
		}
	};

	$scope.delete = (item) => {
		message.dialog().then(
			(x) => {
				TahunAjaranService.delete(item.idtahunajaran).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}

function adminHomeController($scope, $state, AuthService) {}
