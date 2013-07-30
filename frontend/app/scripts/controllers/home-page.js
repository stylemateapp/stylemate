'use strict';

function HomePageController($scope, $rootScope, $state, WeatherService, Search, userLocations, userStyles) {

    $scope.logOut = $rootScope.logOut;

    $scope.location = userLocations.default;
    $scope.location.temperature = 'N/A';
    $scope.location.cloudyClass = '';
    $scope.location.cloudyPhrase = 'Cloud Cover N/A';

    $scope.prepareSearchParams = function() {

        Search.setParam('styles', userStyles.selectedStyles);
        Search.setParam('temperature', $scope.location.temperature);
        Search.setParam('location', $scope.location);
        Search.setParam('date', 'today');
        Search.setParam('cloudyClass', $scope.location.cloudyClass);
    };

    $scope.goToDressForToday = function() {

        $scope.prepareSearchParams();
        $state.transitionTo('choose-occasion');
    };

    var conditions = WeatherService.getCurrentConditions(userLocations.default.latitude, userLocations.default.longitude);

    if (conditions) {

        $scope.location.temperature = Math.round(conditions.getTemperature());

        if(conditions.getCloudCover() >= 0 && conditions.getCloudCover() < 0.4) {

            $scope.location.cloudyClass = 'sunny';
            $scope.location.cloudyPhrase = 'Mostly Sunny';
        }
        else if (conditions.getCloudCover() >= 0.4 && conditions.getCloudCover() < 0.75) {

            $scope.location.cloudyClass = 'partially-cloudy';
            $scope.location.cloudyPhrase = 'Partly Cloudy';
        }
        else if (conditions.getCloudCover() > 0.75) {

            $scope.location.cloudyClass = 'cloudy';
            $scope.location.cloudyPhrase = 'Cloudy';
        }
    }
}

HomePageController.$inject = ['$scope', '$rootScope', '$state', 'WeatherService', 'Search', 'userLocations', 'userStyles'];