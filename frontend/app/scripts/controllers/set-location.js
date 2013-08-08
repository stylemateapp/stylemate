'use strict';

function SetLocationController($scope, $rootScope, $http, $state, GeoLocationService, serverUrl, topLocations) {

    $scope.topLocations = topLocations;
    $scope.errorMessage = '';
    $scope.previousStateName = $rootScope.previousStateName;

    if ($scope.previousStateName === 'sign-up') {

        $scope.className = 'next';
    }
    else {

        $scope.className = 'done';
    }

    $scope.goToNextState = function () {

        var location = $scope.setLocationForm.location.$viewValue;

        $http.post(serverUrl + '/user/setLocation', {location: location})

            .success(function (data, status, error, config) {

                if (data.success === true) {

                    if ($scope.previousStateName === 'sign-up') {

                        $state.transitionTo('choose-styles');
                    }
                    else {

                        $state.transitionTo('homepage');
                    }
                }
                else {

                    $scope.errorMessage = data.errorMessage;
                }
            })

            .error(function (data, status, error, config) {

                $scope.errorMessage = data.errorMessage;
            });
    };
}

SetLocationController.$inject = ['$scope', '$rootScope', '$http', '$state', 'GeoLocationService', 'serverUrl', 'topLocations'];