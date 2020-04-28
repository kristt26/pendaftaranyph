angular
	.module('data.service', [])
	.factory('ContentService', ContentService)
	.factory('SiswaService', SiswaService)
	.factory('PersyaratanService', PersyaratanService)
	.factory('TahunAjaranService', TahunAjaranService);

function ContentService($http, $q, message, AuthService, helperServices) {
	var url = helperServices.url + '/api/content';
	var service = {
		instance: true,
		Items: [
			{
				idcontent: 1,
				title: 'Pelaksanaan Test',
				type: 'pengumuman',
				content:
					'<h5>Pengumuman</h5> <p> Kegunaan dan Fungsi Blog Ada banyak alasan mengapa orang atau perusahaan menggunakan blog. Sebagai contoh, Anda suka memelihara anjing dan ingin membagikan hobi serta kisah yang dimiliki ke audience di internet. Atau Anda sedang mempelajari efek kurang tidur dan ingin menuliskan hasil serta kesimpulan yang ditemukan. Atau mungkin Anda adalah seorang pebisnis dan ingin menawarkan produk yang dimiliki dengan menuliskannya di blog demi meningkatkan awareness dari audience yang lebih besar. Selain tentang alasan pembuatan blog, ada juga yang bertanya apakah benar kita bisa memperoleh penghasilan dengan mengonlinekan blog? Sama seperti website atau jurnal, blog juga memiliki struktur yang tidak kaku. Hal ini dikarenakan blog menawarkan berbagai macam desain dan bentuk, terlebih adanya update secara berkala. Namun, ada fitur yang standar dan terstruktur yang akan Anda sadari ketika membuka dan membaca blog.	</p>',
				publish: true,
				created: new Date()
			}
		]
	};

	service.get = function() {
		var def = $q.defer();
		if (service.instance) {
			def.resolve(service.Items);
		} else {
			$http({
				method: 'Get',
				url: url,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.instance = true;
					service.Items = response.data;
					def.resolve(service.Items);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.getById = function(id) {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.idcontent == id);
			def.resolve(data);
		} else {
			$http({
				method: 'Get',
				url: url + '/' + id,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.Items.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.getPengumuman = function() {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.type == 'pengumuman');
			def.resolve(data);
		} else {
			service.get().then((result) => {
				var data = result.Items.find((x) => x.type == 'pengumuman');
				def.resolve(data);
			});
		}

		return def.promise;
	};

	service.getInformasi = function() {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.type == 'informasi');
			def.resolve(data);
		} else {
			service.get().then((result) => {
				var data = result.Items.find((x) => x.type == 'informasi');
				def.resolve(data);
			});
		}

		return def.promise;
	};

	service.post = function(param) {
		var def = $q.defer();
		$http({
			method: 'Post',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				service.Items.push(response.data);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);

		return def.promise;
	};

	service.put = function(param) {
		var def = $q.defer();
		$http({
			method: 'Put',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idpegawai == param.idpegawai);
				if (data) {
					data.nip = param.nip;
					data.nama = param.nama;
					data.jeniskelamin = param.jeniskelamin;
					data.jabatan = param.jabatan;
					data.alamat = param.alamat;
					data.kontak = param.kontak;
					data.pendidikan = param.penidikan;
				}

				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	service.delete = function(id) {
		var def = $q.defer();
		$http({
			method: 'Delete',
			url: url + '/' + id,
			headers: AuthService.getHeader()
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idpegawai == id);
				if (data) {
					var index = service.Items.indexOf(data);
					service.Items.splice(index, 1);
					def.resolve(true);
				}
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	return service;
}

function SiswaService($http, $q, message, AuthService, helperServices) {
	var url = helperServices.url + '/api/siswa';
	var service = { Items: [] };

	service.get = function() {
		var def = $q.defer();
		if (service.instance) {
			def.resolve(service.Items);
		} else {
			$http({
				method: 'Get',
				url: url,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.instance = true;
					service.Items = response.data;
					def.resolve(service.Items);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.getById = function(id) {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.idkategori == id);
			def.resolve(data);
		} else {
			$http({
				method: 'Get',
				url: url + '/' + id,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.Items.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.post = function(param) {
		var def = $q.defer();
		$http({
			method: 'Post',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				service.Items.push(response.data);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);

		return def.promise;
	};

	service.put = function(param) {
		var def = $q.defer();
		$http({
			method: 'Put',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idsiswa == param.idsiswa);
				if (data) {
					data.nis = param.nis;
					data.nama = param.nama;
					data.jeniskelamin = param.jeniskelamin;
					data.jurusan = param.jurusan;
					data.alamat = param.alamat;
					data.kontak = param.kontak;
					data.kelas = param.kelas;
					data.tempatlahir = param.tempatlahir;
					data.tanggallahir = param.tanggallahir;
				}

				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	service.delete = function(id) {
		var def = $q.defer();
		$http({
			method: 'Delete',
			url: url + '/' + id,
			headers: AuthService.getHeader()
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idsiswa == id);
				if (data) {
					var index = service.Items.indexOf(data);
					service.Items.splice(index, 1);
					def.resolve(true);
				}
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	return service;
}

function PersyaratanService($http, $q, message, AuthService, helperServices) {
	var url = helperServices.url + '/api/persyaratan';
	var service = {
		Items: []
	};

	service.get = function() {
		var def = $q.defer();
		if (service.instance) {
			def.resolve(service.Items);
		} else {
			$http({
				method: 'Get',
				url: url,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.instance = true;
					if (!response.data) {
						service.Items = [];
					} else service.Items = response.data;
					def.resolve(service.Items);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.getById = function(id) {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.idkategori == id);
			def.resolve(data);
		} else {
			$http({
				method: 'Get',
				url: url + '/' + id,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.Items.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.post = function(param) {
		var def = $q.defer();
		$http({
			method: 'Post',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				service.Items.push(response.data);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);

		return def.promise;
	};

	service.put = function(param) {
		var def = $q.defer();
		$http({
			method: 'Put',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idsiswa == param.idtahunajaran);
				if (data) {
					data.persyaratan = param.persyaratan;
					data.status = param.status;
				}
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	service.delete = function(param) {
		var def = $q.defer();
		$http({
			method: 'Delete',
			url: url + '/' + param,
			headers: AuthService.getHeader()
		}).then(
			(response) => {
				var index = service.Items.indexOf(param);
				service.Items.splice(index, 1);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	return service;
}

function TahunAjaranService($http, $q, message, AuthService, helperServices) {
	var url = helperServices.url + '/api/tahunajaran';
	var service = {
		Items: []
	};

	service.get = function() {
		var def = $q.defer();
		if (service.instance) {
			def.resolve(service.Items);
		} else {
			$http({
				method: 'Get',
				url: url,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.instance = true;
					if (!response.data) {
						service.Items = [];
					} else service.Items = response.data;
					def.resolve(service.Items);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.getById = function(id) {
		var def = $q.defer();
		if (service.instance) {
			var data = service.Items.find((x) => x.idkategori == id);
			def.resolve(data);
		} else {
			$http({
				method: 'Get',
				url: url + '/' + id,
				headers: AuthService.getHeader()
			}).then(
				(response) => {
					service.Items.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		}

		return def.promise;
	};

	service.post = function(param) {
		var def = $q.defer();
		$http({
			method: 'Post',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				service.Items.push(response.data);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);

		return def.promise;
	};

	service.put = function(param) {
		var def = $q.defer();
		$http({
			method: 'Put',
			url: url,
			headers: AuthService.getHeader(),
			data: param
		}).then(
			(response) => {
				var data = service.Items.find((x) => x.idsiswa == param.idtahunajaran);
				if (data) {
					data.tahunajaran = param.tahunajaran;
					data.semester = param.semester;
					data.status = param.status;
				}
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	service.delete = function(param) {
		var def = $q.defer();
		$http({
			method: 'Delete',
			url: url + '/' + param,
			headers: AuthService.getHeader()
		}).then(
			(response) => {
				var index = service.Items.indexOf(param);
				service.Items.splice(index, 1);
				def.resolve(response.data);
			},
			(err) => {
				message.error(err.data);
				def.reject(err);
			}
		);
		return def.promise;
	};

	return service;
}
