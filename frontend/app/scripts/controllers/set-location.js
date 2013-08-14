'use strict';

function SetLocationController($scope, $rootScope, $http, $state, serverUrl, topLocations) {

    $scope.topLocations = topLocations;
    $scope.errorMessage = '';
    $scope.previousStateName = $rootScope.previousStateName;
    $scope.locations = [];
    $scope.locations.default = [];
    $scope.locations.otherLocations = [];

    if ($scope.previousStateName === 'sign-up') {

        $scope.className = 'next';
    }
    else {

        $scope.className = 'done';
    }

    $scope.goToNextState = function () {

        var defaultLocation = $scope.locations.default;

        if (defaultLocation) {

            if ($scope.previousStateName === 'sign-up') {

                $state.transitionTo('choose-styles');
            }
            else {

                $state.transitionTo('homepage');
            }
        }
        else {

            $scope.errorMessage = 'You have not selected default location';
        }
    };
}

SetLocationController.$inject = ['$scope', '$rootScope', '$http', '$state', 'serverUrl', 'topLocations'];