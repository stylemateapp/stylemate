'use strict';

function HomePageController($scope, $rootScope, $state, WeatherService, Search, userLocations, userStyles) {

	$scope.logOut = $rootScope.logOut;

	$scope.location = userLocations.default;
	$scope.location.temperature = '40';
	$scope.location.cloudyClass = '';
	$scope.location.cloudyPhrase = 'Partly Cloudy';

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

	var conditions = WeatherService.getCurrentConditions(userLocations.default.latitude, userLocations.default.longitude);

	if (conditions) {

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

HomePageController.$inject = ['$scope', '$rootScope', '$state', 'WeatherService', 'Search', 'userLocations', 'userStyles'];