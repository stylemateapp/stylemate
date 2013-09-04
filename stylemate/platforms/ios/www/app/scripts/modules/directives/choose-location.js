/**
 * PLEASE NOTE THAT THIS DIRECTIVE HAS SHARED WITH CONTROLLER SCOPE
 */

Object.prototype.findByName = function (value) {

    for (var prop in this) {

        if (this.hasOwnProperty(prop)) {

            if(this[prop] && this[prop].name && this[prop].name === value) return prop;
        }
    }
};

angular.module('stylemate.directives', [])

    .directive('chooseLocation', function () {
        return {
            restrict: 'EA',
            transclude: false,
            replace: false,
            controller: function ($scope, $element, $attrs, $http, serverUrl) {

                document.addEventListener('deviceready',

                    function () {

                        navigator.geolocation.getCurrentPosition(

                            function (position) {

                                $scope.$apply(function () {

                                    $http.post(serverUrl + '/user/setDefaultLocation/', {latitude: position.coords.latitude, longitude: position.coords.longitude})

                                        .then(function (result) {

                                            $scope.locations = result.data.locations;
                                        });
                                });
                            });
                    }

                    , false);

                $http.get(serverUrl + '/user/getLocations/')

                    .success(function (data) {

                        $scope.locations = data.locations;
                    });

                $scope.addLocation = function (name) {

                    if ($scope.locations.default.name && $scope.locations.default.name == name) return;

                    var length = Object.keys($scope.locations.otherLocations).length;

                    if (length < 4) {

                        var found = $scope.locations.otherLocations.findByName(name);

                        if (!found) {

                            $http.post(serverUrl + '/user/setLocation', {location: name})

                                .success(function (data) {

                                    $scope.errorMessage = '';
                                    $scope.search_city = '';
                                    $scope.locations = data.locations;
                                });
                        }
                        else {

                            $scope.errorMessage = 'This location is already added';
                        }
                    }
                    else {

                        $scope.errorMessage = 'No more than 5 locations please';
                    }

                    $scope.ajaxDropdownData = [];
                };

                $scope.deleteLocation = function (name) {

                    var found = $scope.locations.otherLocations.findByName(name);

                    if (found) {

                        $http.post(serverUrl + '/user/deleteLocation', {location: name})

                            .success(function (data) {

                                $scope.errorMessage = '';
                                $scope.locations = data.locations;
                            });
                    }
                };

                $element.bind('keyup', function (evt) {

                    $scope.$apply(function () {

                        $scope.handleKeypress.call($scope, evt.which);
                    });
                });

                $scope.handleKeypress = function (key) {

                    if($scope.search_city && $scope.search_city.length >= 3) {

                        var url = "http://gd.geobytes.com/AutoCompleteCity?callback=JSON_CALLBACK&q=" + $scope.search_city;

                        $http.jsonp(url)

                            .success(function (data) {

                                $scope.ajaxDropdownData = data.splice(0, 7);
                            });
                    }
                    else {

                        $scope.ajaxDropdownData = [];
                    }
                };
            },
            template:  '<div class="locations-block"><input type="text" class="text-field search-location" ng-model="search_city" placeholder="start typing">' +
                       '<ul class="location-ajax-dropdown"><li ng-repeat="city in ajaxDropdownData" ng-click="addLocation(city)">{{city}}</li></ul>' +
                       '<ul class="other-locations">' +
                           '<li ng-repeat="location in locations.otherLocations"><span class="text">{{location.name}}</span><span class="location-delete" ng-click="deleteLocation(location.name)"></span></li>' +
                       '</ul>' +
                       '<div class="sub-header">OR CHOOSE FROM TOP CITIES</div>' +
                       '<ul class="choose-location">' +
                           '<li ng-repeat="location in topLocations" ng-click="addLocation(location)">{{location}}</li>' +
                       '</ul></div>'
        };
    });