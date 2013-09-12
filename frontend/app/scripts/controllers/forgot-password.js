'use strict';

function ForgotPasswordController($scope, $state, $http, serverUrl, FacebookService) {

    $scope.errorMessage = '';
	$scope.userData = '';
	$scope.part1 = true;
	$scope.part2 = false;

    $scope.goNext = function () {
		
		$scope.part1 = false;
		$scope.part2 = true;
    };

    $scope.gatherFacebookInfo = function () {

        FacebookService.init();

        $scope.$on('event:gatheredFacebookData', function () {
			
			$scope.userData = FacebookService.email;
			
			$scope.part1 = false;
			$scope.part2 = true;
			
			$scope.$apply();
        });
    };
	
	$scope.sendPassword = function () {

        if ($scope.forgotPasswordPartTwoForm.$valid) {

            $http.post(serverUrl + '/user/remindPassword', {userData: $scope.userData})

                .success(function (data) {

                    if (data.success === true) {

                        alert('We just sent you password. Check your email please.');
                    }
                    else {

                        $scope.errorMessage = data.errorMessage;
                    }
                })

                .error(function (data) {

                    $scope.errorMessage = data.errorMessage;
                });
        }
    };
}

ForgotPasswordController.$inject = ['$scope', '$state', '$http', 'serverUrl', 'FacebookService'];