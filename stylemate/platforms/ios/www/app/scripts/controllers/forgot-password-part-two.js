'use strict';

function ForgotPasswordPartTwoController($scope, $http, serverUrl, FacebookService) {

    $scope.errorMessage = '';
    $scope.userData = FacebookService.email;

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

ForgotPasswordPartTwoController.$inject = ['$scope', '$http', 'serverUrl', 'FacebookService'];