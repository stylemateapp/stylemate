'use strict';

function SignUpController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.goToSetLocation = function() {

        $http.post(serverUrl + '/user/signUp', {email: $scope.email, password: $scope.password})

            .success(function (data, status, error, config) {

                if (data.success === true) {

                    $scope.login();

                }
                else {

                    $scope.errorMessage = data.errorMessage;
                }
            })

            .error(function (data, status, error, config) {

                $scope.errorMessage = data.errorMessage;
            });

    };

    $scope.login = function () {

        $http.post(serverUrl + '/user/login', {email: $scope.email, password: $scope.password})

            .success(function (data, status, error, config) {

                if (data.success === true) {

                    $rootScope.$broadcast('event:loginSuccess');
                    $state.transitionTo('set-location');

                }
                else {

                    $scope.errorMessage = 'Error logging in using newly created user';
                }
            })

            .error(function (data, status, error, config) {

                $scope.errorMessage = 'Error logging in using newly created user';
            });
    };
}

SignUpController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];