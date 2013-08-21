'use strict';

function SignUpController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.goToSetLocation = function() {

        $http.post(serverUrl + '/user/signUp', {username: $scope.username, name: $scope.name, email: $scope.email, password: $scope.password})

            .success(function (data) {

                if (data.success === true) {

                    $scope.login();

                }
                else {

                    $scope.errorMessage = data.errorMessage;
                }
            })

            .error(function (data) {

                $scope.errorMessage = data.errorMessage;
            });

    };

    $scope.login = function () {

        $http.post(serverUrl + '/user/login', {username: $scope.username, password: $scope.password})

            .success(function (data) {

                if (data.success === true) {

                    $rootScope.$broadcast('event:loginSuccess');
                    $state.transitionTo('set-location');

                }
                else {

                    $scope.errorMessage = 'Error logging in using newly created user';
                }
            })

            .error(function () {

                $scope.errorMessage = 'Error logging in using newly created user';
            });
    };

    $scope.facebookLogin = function() {

        FB.login(function (response) {

                if (response.authResponse) {

                    FB.api('/me', function (response) {

                        $scope.$apply(function () {

                            if (response.email) {

                                $scope.email = response.email;
                            }

                            if (response.name) {

                                $scope.name = response.name;
                            }
                        });
                    });

                }
                else {

                }
            },
            {
                scope: 'email'
            });
    };
}

SignUpController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];