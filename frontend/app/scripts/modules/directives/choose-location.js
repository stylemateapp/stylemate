/**
 * PLEASE NOTE THAT THIS DIRECTIVE HAS SHARED WITH CONTROLLER SCOPE
 */

Object.prototype.findByName = function (value) {

    for (var prop in this) {

        if (this.hasOwnProperty(prop)) {

            if(this[prop].name && this[prop].name === value) return prop;
        }
    }
};

angular.module('stylemate.directives')

    .directive('chooseLocation', function () {
        return {
            restrict: 'EA',
            transclude: false,
            replace: false,
            controller: function ($scope, $element, $attrs, $http, serverUrl) {

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

                                    $scope.locations = data.locations;
                                });
                        }
                    }
                };

                $scope.deleteLocation = function (name) {

                    var found = $scope.locations.otherLocations.findByName(name);

                    if (found) {

                        $http.post(serverUrl + '/user/deleteLocation', {location: name})

                            .success(function (data) {

                                $scope.locations = data.locations;
                            });
                    }
                };

                $element.bind('keyup', function (evt) {

                    // HERE CALL AJAX DROPDOWN

                    $scope.$apply(function () {

                        $scope.handleKeypress.call($scope, evt.which);
                    });
                });

                $scope.handleKeypress = function (key) {


                };
            },
            template:  '<input type="text" class="text-field search-location" ng-model="location" name="location" id="location" placeholder="start typing">' +
                       '<ul class="other-locations">' +
                           '<li ng-repeat="location in locations.otherLocations"><span class="text">{{location.name}}</span><span class="location-delete" ng-click="deleteLocation(location.name)"></span></li>' +
                       '</ul>' +
                       '<div class="sub-header">OR CHOOSE FROM TOP CITIES</div>' +
                       '<ul class="choose-location">' +
                           '<li ng-repeat="location in topLocations" ng-click="addLocation(location)">{{location}}</li>' +
                       '</ul>'
        };
    });