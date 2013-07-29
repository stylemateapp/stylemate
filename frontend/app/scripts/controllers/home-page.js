'use strict';

function HomePageController($scope, $rootScope, WeatherService, userLocations) {

    $scope.logOut = $rootScope.logOut;

    $scope.location = userLocations.default;
    $scope.location.temperature = 'N/A';
    $scope.location.cloudyClass = '';
    $scope.location.cloudyPhrase = 'Cloud Cover N/A';

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

HomePageController.$inject = ['$scope', '$rootScope', 'WeatherService', 'userLocations'];