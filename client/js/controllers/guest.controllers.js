angular
	.module('guest.controller', [])
	.controller('guestController', guestController)
	.controller('guestHomeController', guestHomeController)
	.controller('informasiController', informasiController);

function guestController($scope, $state, AuthService, StorageService) {}

function guestHomeController($scope, $state, AuthService, StorageService) {}

function informasiController($scope, $state, AuthService, StorageService) {}
