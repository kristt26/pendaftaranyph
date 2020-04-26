angular.module('calon.service', []).factory('CalonSiswaService', CalonSiswaService);

function CalonSiswaService($http, $q, message, AuthService, helperServices) {
	var service = {};
	service.siswa = {};

	service.saveCalonSiswa = function(model) {
		var def = $q.defer();
		var url = helperServices.url + '/api/calonsiswa';
		if (!model.idcalonsiswa) {
			$http({
				method: 'Post',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					service.siswa = response.data;
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		} else {
			$http({
				method: 'PUT',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					//update Item
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

	service.addBeasiswa = function(model) {
		var def = $q.defer();
		var url = helperServices.url + '/api/beasiswa';
		if (!model.idbeasiswa) {
			$http({
				method: 'Post',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					service.siswa.beasiswa.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		} else {
			$http({
				method: 'PUT',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					//update Item
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

	service.addOrangTua = function(model) {
		var def = $q.defer();
		var url = helperServices.url + '/api/orangtua';
		if (!model.idorangtua) {
			$http({
				method: 'Post',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					service.siswa.orangtua.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		} else {
			$http({
				method: 'PUT',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					//update Item
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

	service.addKesejahteraan = function(model) {
		var def = $q.defer();
		var url = helperServices.url + '/api/kesejahteraan';
		if (!model.idorangtua) {
			$http({
				method: 'Post',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					service.siswa.kesejahteraan.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		} else {
			$http({
				method: 'PUT',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					//update Item
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

	service.addPrestasi = function(model) {
		var def = $q.defer();
		var url = helperServices.url + '/api/prestasi';

		if (!model.idcalonsiswa) model.idcalonsiswa = service.idcalonsiswa;

		if (!model.idorangtua) {
			$http({
				method: 'Post',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					service.siswa.prestasi.push(response.data);
					def.resolve(response.data);
				},
				(err) => {
					message.error(err.data);
					def.reject(err);
				}
			);
		} else {
			$http({
				method: 'PUT',
				url: url,
				headers: AuthService.getHeader(),
				data: model
			}).then(
				(response) => {
					//update Item
					var data = service.siswa.prestasi.find((x) => (x.idprestasi = model.idprestasi));
					data.tahun = model.tahun;
					data.tingkat = model.tingkat;
					data.namaprestasi = model.namaprestasi;
					data.jenisprestasi = model.jenisprestasi;
					data.penyelengaraan = model.penyelengaraan;

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

	return service;
}
