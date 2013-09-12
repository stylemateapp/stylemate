'use strict';

function SignUpController($scope, $http, $rootScope, $state, serverUrl, FacebookService) {

    $scope.errorMessage = '';

    $scope.goNext = function() {

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

                    if($rootScope.geoLocation.enabled) {

                        $http.post(
                            serverUrl + '/user/setDefaultLocation/', {
                                latitude: $rootScope.geoLocation.position.coords.latitude,
                                longitude: $rootScope.geoLocation.position.coords.longitude
                            })

                            .then(function () {

                                $state.transitionTo('choose-styles');
                            });
                    }
                    else {

                        $state.transitionTo('set-location');
                    }
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

        FacebookService.init();

        $scope.$on('event:gatheredFacebookData', function () {

            $scope.email = FacebookService.email;
            $scope.name = FacebookService.name;
			
			$scope.$apply();
        });

    };
}

SignUpController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl', 'FacebookService'];