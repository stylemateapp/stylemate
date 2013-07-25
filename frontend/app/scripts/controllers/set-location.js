'use strict';

function SetLocationController($scope, $http, $state, GeoLocationService, serverUrl, topLocations) {

    $scope.topLocations = topLocations;

    $scope.goToChooseStyles = function () {

        var location = $scope.setLocationForm.location.$viewValue;

        $http.post(serverUrl + '/user/setLocation', {location: location})

            .success(function (data, status, error, config) {

                if (data.success === true) {

                    $state.transitionTo('choose-styles');

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

SetLocationController.$inject = ['$scope', '$http', '$state', 'GeoLocationService', 'serverUrl', 'topLocations'];