'use strict';

function HomePageController($scope, $http,  $state, serverUrl) {

    $scope.checkUserLocation = function () {

        $http.get(serverUrl + '/user/getLocation/')

            .success(function (data, status, error, config) {

                $scope.checkUserStyles();
            })

            .error(function (data, status, error, config) {

                $state.transitionTo('set-location');
            });
    };

    $scope.checkUserStyles = function () {

        // TODO

    };

    $scope.checkUserLocation();
}

HomePageController.$inject = ['$scope', '$http', '$state', 'serverUrl'];