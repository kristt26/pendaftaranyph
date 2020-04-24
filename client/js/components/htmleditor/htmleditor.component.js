const appHtmlEditor = {
	controller: function($scope, AuthService) {
		tinymce.init({
			selector: 'textarea#basic-example',
			height: 500,
			menubar: true,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'image',
				'insertdatetime media table paste code help wordcount'
			],
			toolbar:
				'undo redo | formatselect | ' +
				'bold italic backcolor | alignleft aligncenter ' +
				'alignright alignjustify | bullist numlist outdent indent | ' +
				'removeformat | help | image',
			content_css: 'client/assets/vendor/bootstrap/css/bootstrap.min.css'
		});

		$scope.isLogin = AuthService.userIsLogin();
		if ($scope.isLogin) {
			// AuthService.profile().then((profile) => {
			// 	$scope.profile = profile;
			// });
		}

		$scope.logoff = function() {
			AuthService.logOff();
		};

		$scope.updateAdminProfile = (iduser, photodata) => {
			AuthService.updatePhotoProfile(iduser, photodata).then((x) => {});
		};
	},
	templateUrl: 'client/js/components/htmleditor/htmleditor.html'
};

const appHtmlView = {
	controller: function($scope, AuthService) {},
	templateUrl: 'client/js/components/htmleditor/htmlview.html'
};

angular
	.module('app.htmleditor.conponent', [])
	.component('app.htmleditor', appHtmlEditor)
	.component('app.htmlview', appHtmlView);
