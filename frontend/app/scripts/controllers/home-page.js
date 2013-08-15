'use strict';

function HomePageController($scope, $rootScope, $state, WeatherService, Search, userLocations, userStyles) {

	$scope.logOut = $rootScope.logOut;
    $scope.currentKey = 'default';

	$scope.location = userLocations.default;
	$scope.location.temperature = '40';
	$scope.location.cloudyClass = '';
	$scope.location.cloudyPhrase = 'Partly Cloudy';

    changeLocation(userLocations.default);

	$scope.goToDressForToday = function () {

		Search.setParam('styles', userStyles.selectedStyles);
		Search.setParam('temperature', $scope.location.temperature);
		Search.setParam('location', $scope.location);
		Search.setParam('date', 'today');
		Search.setParam('cloudyClass', $scope.location.cloudyClass);

		$state.transitionTo('choose-occasion');
	};

	$scope.goToDressForFuture = function () {

		Search.setParam('styles', userStyles.selectedStyles);
		Search.setParam('temperature', $scope.location.name);
		Search.setParam('location', $scope.location.name);
		Search.setParam('date', '');
		Search.setParam('cloudyClass', '');

		$state.transitionTo('dress-for-future-date');
	};

    $scope.isNext = function () {

        if ($scope.currentKey == 'default') {

            return userLocations.otherLocations[0];
        }

        return userLocations.otherLocations[$scope.currentKey + 1];
    };

    $scope.goNext = function() {

        if($scope.currentKey == 'default') {

            if(userLocations.otherLocations[0]) {

                $scope.currentKey = 0;

                changeLocation(userLocations.otherLocations[$scope.currentKey]);
            }
        }
        else {

            if(userLocations.otherLocations[$scope.currentKey + 1]) {

                $scope.currentKey++;

                changeLocation(userLocations.otherLocations[$scope.currentKey]);
            }
        }
    };

    $scope.isPrevious = function() {

        if($scope.currentKey == 'default') {

            return false;
        }

        if($scope.currentKey == 0) {

            return true;
        }

        return userLocations.otherLocations[$scope.currentKey - 1];
    };

    $scope.goPrevious = function () {

        if ($scope.currentKey != 'default') {

            if ($scope.currentKey == 0) {

                $scope.currentKey = 'default';

                changeLocation(userLocations.default);
            }
            else {

                if (userLocations.otherLocations[$scope.currentKey - 1]) {

                    $scope.currentKey--;

                    changeLocation(userLocations.otherLocations[$scope.currentKey]);
                }
            }
        }
    };

    function changeLocation(location) {

        var conditions = WeatherService.getCurrentConditions(location.latitude, location.longitude);

        if (conditions) {

            $scope.location = location;
            $scope.location.temperature = Math.round(conditions.getTemperature());

            var icon = conditions.getIcon();

            if (icon == "clear-day") {

                $scope.location.cloudyClass = 'sunny';
                $scope.location.cloudyPhrase = 'Mostly Sunny';
            }
            else if (icon == "partly-cloudy-day") {

                $scope.location.cloudyClass = 'partially-cloudy';
                $scope.location.cloudyPhrase = 'Partly Cloudy';
            }
            else if (icon == "cloudy") {

                $scope.location.cloudyClass = 'cloudy';
                $scope.location.cloudyPhrase = 'Cloudy';
            }
            else if (icon == "clear-night") {

                $scope.location.cloudyClass = 'night';
                $scope.location.cloudyPhrase = 'Clear Night';
            }
            else if (icon == "partly-cloudy-night") {

                $scope.location.cloudyClass = 'cloudy-night';
                $scope.location.cloudyPhrase = 'Cloudy Night';
            }
            else if (icon == "rain") {

                $scope.location.cloudyClass = 'rain';
                $scope.location.cloudyPhrase = 'Rain';
            }
            else if (icon == "snow") {

                $scope.location.cloudyClass = 'snow';
                $scope.location.cloudyPhrase = 'Snow';
            }
        }
    }
}

HomePageController.$inject = ['$scope', '$rootScope', '$state', 'WeatherService', 'Search', 'userLocations', 'userStyles'];