'use strict';

function DressForFutureLocationController($scope, $http, $state, GeoLocationService, Search, userStyles, topLocations) {

    $scope.topLocations = topLocations;
    $scope.errorMessage = '';

    Search.setParam('occasion', -1);

    $scope.goToSelectDay = function () {

        var location = $scope.setLocationForm.location.$viewValue;

        if(location == '' || typeof location == 'undefined') {

            $scope.errorMessage = 'Please provide non-empty location';
        }
        else {

            Search.setParam('styles', userStyles.selectedStyles);
            Search.setParam('temperature', location);
            Search.setParam('location', location);
            Search.setParam('date', '');
            Search.setParam('cloudyClass', '');

            $state.transitionTo('dress-for-future-date');
        }
    };
}

DressForFutureLocationController.$inject = ['$scope', '$http', '$state', 'GeoLocationService', 'Search', 'userStyles', 'topLocations'];