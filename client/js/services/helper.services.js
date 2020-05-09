angular.module('helper.service', []).factory('helperServices', helperServices);

function helperServices($location) {
	var service = { IsBusy: false };
	service.url = $location.$$protocol + '://' + $location.$$host;
	if ($location.$$port) {
		service.url = service.url + ':' + $location.$$port;
	}

	// '    http://localhost:5000';

	service.groupBy = (list, keyGetter) => {
		const map = new Map();
		list.forEach((item) => {
			const key = keyGetter(item);
			const collection = map.get(key);
			if (!collection) {
				map.set(key, [ item ]);
			} else {
				collection.push(item);
			}
		});
		return map;
	};

	service.genders = [ 'Pria', 'Wanita' ];
	service.jurusan = [ 'IPA', 'IPS', 'BAHASA' ];
	service.statusLulus = [ 'Lulus', 'Tidak Lulus' ];
	service.kelas = [ 'Fisika', 'Kimia', 'Biologi', 'Ekonomi', 'Sosiologi', 'Geografi' ];
	service.tingkat = [ 'Daerah', 'Nasional', 'Internasional' ];
	service.pekerjaan = [ 'Pegawai', 'Petani', 'Guru' ];
	service.pendidikan = [ 'SD', 'SMP', 'SMA', 'S1', 'S2', 'S3' ];
	service.semester = [ '1', '2' ];

	service.pendapatan = [ '> 1000000', '> 200000', '> 3000000' ];
	service.tahunlahir = range(1930, 2010);


	function range(start, end) {
		var ans = [];
		for (let i = start; i <= end; i++) {
			ans.push(i);
		}
		return ans;
	}

	

	return service;
}
