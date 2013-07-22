'use strict';

function LoginController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.login = function (formInvalid) {

        if(!formInvalid) {

            var signInButton =  angular.element(document.getElementById('sign-in-button'));

            signInButton.attr('disabled', 'disabled');

            $http.post(serverUrl + '/user/login', {email: $scope.email, password: $scope.password})

                .success(function (data, status, error, config) {

                    if (data.success === true) {

                        $rootScope.$broadcast('event:loginSuccess');
                        $state.transitionTo('homepage');

                    }
                    else {

                        $scope.errorMessage = 'User with provided email and password was not found';
                    }

                    signInButton.removeAttr('disabled');
                })

                .error(function (data, status, error, config) {

                    $scope.errorMessage = 'Error logging in';

                    signInButton.removeAttr('disabled');
                });
        }
        else {

            $scope.errorMessage = 'Please fill in email and password';
        }
    };
}

LoginController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];