angular
	.module('admin.controller', [])
	.controller('adminController', adminController)
	.controller('adminSiswaController', adminSiswaController)
	.controller('adminPengumumanController', adminPengumumanController)
	.controller('adminInformasiController', adminInformasiController)
	.controller('adminTahunAjaranController', adminTahunAjaranController)
	.controller('adminPersyaratanController', adminPersyartanController)
	.controller('adminHomeController', adminHomeController);

function adminController($scope, $state, AuthService) {
	// if (!AuthService.userIsLogin()) {
	// 	$state.go('login');
	// }
}

function adminPersyartanController($scope, message, PersyaratanService, helperServices) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	PersyaratanService.get().then((result) => {
		$scope.helper.IsBusy = false;
		$scope.source = result;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.title = 'Edit Persyaratan';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idpersyaratan) {
			PersyaratanService.put(model).then(
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
			PersyaratanService.post(model).then(
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
				PersyaratanService.delete(item.idpegawai).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}
function adminSiswaController($scope, message, SiswaService, helperServices) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	SiswaService.get().then((result) => {
		$scope.source = result;
		$scope.helper.IsBusy = false;
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
function adminPengumumanController($scope, message, ContentService, helperServices) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	ContentService.get().then((result) => {
		$scope.source = result;
		$scope.helper.IsBusy = false;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.title = 'Edit Pengumuman';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idpegawai) {
			ContentService.put(model).then(
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
			ContentService.post(model).then(
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
				ContentService.delete(item.idpegawai).then((x) => {
					message.info('Data Berhasil Dihapus');
				});
			},
			(err) => {
				message.error('Data Gagal Dihapus');
			}
		);
	};
}

function adminInformasiController($scope, ContentService, message, helperServices, TahunAjaranService) {
	$scope.helper = helperServices;
	$scope.helper.IsBusy = true;
	ContentService.get().then((result) => {
		$scope.source = result;
		$scope.helper.IsBusy = false;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.title = 'Edit Informasi';
	};
	$scope.save = (model) => {
		$scope.helper.IsBusy = true;
		if (model.idpegawai) {
			ContentService.put(model).then(
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
			ContentService.post(model).then(
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
				ContentService.delete(item.idpegawai).then((x) => {
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
	$scope.helper.IsBusy = true;
	TahunAjaranService.get().then((result) => {
		$scope.source = result;
		$scope.helper.IsBusy = false;
	});

	$scope.edit = (model) => {
		$scope.model = angular.copy(model);
		$scope.model.tanggalbuka = new Date(model.tanggalbuka);
		$scope.model.tanggaltutup = new Date(model.tanggaltutup);
		$scope.title = 'Edit Tahun Ajaran';
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
