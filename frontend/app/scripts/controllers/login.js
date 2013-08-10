'use strict';

function LoginController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.login = function (formInvalid) {

        if(!formInvalid) {

            $http.post(serverUrl + '/user/login', {username: $scope.username, password: $scope.password})

                .success(function (data) {

                    if (data.success === true) {

                        $rootScope.$broadcast('event:loginSuccess');
                        $state.transitionTo('homepage');

                    }
                    else {

                        $scope.errorMessage = 'User with provided username and password was not found';
                    }
                })

                .error(function () {

                    $scope.errorMessage = 'Error logging in';
                });
        }
        else {

            $scope.errorMessage = 'Please fill in username and password correctly';
        }
    };
}

LoginController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];