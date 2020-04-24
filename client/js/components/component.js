angular
	.module('app.conponent', [
		'app.account.conponent',
		'app.cart.conponent',
		'app.fileInput.conponent',
		'app.kategori.conponent',
		'app.publish.conponent',
		'app.chat.conponent',
		'app.inbox.conponent'
	])
	.component('cari', {
		bindings: { value: '<', placeholder: '@' },
		controller: function($scope, $rootScope) {
			$scope.searchText = '';
			$scope.change = (value) => {
				$rootScope.$broadcast('cariEvent', value);
			};
		},
		template:
			'<input class="form-search" ng-model="searchText" ng-change="change(searchText)" type="text" placeholder="{{$ctrl.placeholder}}">'
	});
