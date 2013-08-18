'use strict';

function HomePageController($scope, $rootScope, $state, WeatherService, Search, userLocations, userStyles) {

	$scope.logOut = $rootScope.logOut;
    $scope.currentKey = 'default';

	$scope.location = userLocations.default;
	$scope.location.temperature = '60';
	$scope.location.cloudyClass = '';
	$scope.location.cloudyPhrase = 'Clear';

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
            var timeOfDay = conditions.getTimeOfDay();

            if (icon == 'clear-day' || icon == 'clear-night' || icon == 'wind') {

                $scope.location.cloudyPhrase = 'Clear';
                $scope.location.cloudyClass = 'clear' + '-' + timeOfDay;
            }

            if (icon == 'partly-cloudy-day' || icon == 'cloudy' || icon == 'partly-cloudy-night') {

                $scope.location.cloudyPhrase = 'Cloudy';
                $scope.location.cloudyClass = 'cloudy' + '-' + timeOfDay;
            }

            if (icon == 'rain' || icon == 'snow') {

                $scope.location.cloudyPhrase = 'Rainy';
                $scope.location.cloudyClass = 'rainy' + '-' + timeOfDay;
            }
        }
    }
}

HomePageController.$inject = ['$scope', '$rootScope', '$state', 'WeatherService', 'Search', 'userLocations', 'userStyles'];