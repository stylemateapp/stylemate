'use strict';

function LoginController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.login = function (formInvalid) {

        if(!formInvalid) {

            $http.post(serverUrl + '/user/login', {email: $scope.email, password: $scope.password})

                .success(function (data, status, error, config) {

                    if (data.success === true) {

                        $rootScope.$broadcast('event:loginSuccess');
                        $state.transitionTo('homepage');

                    }
                    else {

                        $scope.errorMessage = 'User with provided email and password was not found';
                    }
                })

                .error(function (data, status, error, config) {

                    $scope.errorMessage = 'Error logging in';
                });
        }
        else {

            $scope.errorMessage = 'Please fill in email and password correctly';
        }
    };
}

LoginController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];