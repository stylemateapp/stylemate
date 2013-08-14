angular.module('stylemate.directives')

    .directive('chooseLocation', function () {
        return {
            restrict: 'EA',
            transclude: false,
            replace: false,
            scope: {
                'topLocations': '=',
                'otherLocations': '='
            },
            controller: function ($scope, $element, $http, serverUrl) {

                if(!$scope.otherLocations) {

                    $scope.otherLocations = [];
                }

                /*$scope.addLocation = function (value) {

                    if ($scope.addedLocations.indexOf(value) == -1) {

                        $http.post(serverUrl + '/user/setLocation', {location: value})

                            .success(function (data) {

                                $scope.addedLocations.push(value);
                            });
                    }
                };*/

                $scope.addLocation = function (value) {

                    if ($scope.otherLocations.length < 4) {

                        function findByName(source, name) {

                            return source.filter(function (obj) {

                                return obj.name.toLowerCase() == name.toLowerCase();
                            })[0];
                        }

                        if (typeof findByName($scope.otherLocations, value) == 'undefined') {

                            $http.post(serverUrl + '/user/setLocation', {location: value})

                                .success(function () {

                                    $scope.otherLocations.push({name: value});
                                });
                        }
                    }
                };

                $scope.deleteLocation = function (name) {

                    var pos = $scope.otherLocations.indexOf(name);

                    if (pos >= -1) {

                        $http.post(serverUrl + '/user/deleteLocation', {location: name})

                            .success(function () {

                                $scope.otherLocations.splice(pos, 1);
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
                           '<li ng-repeat="location in otherLocations"><span class="text">{{location.name}}</span><span class="location-delete" ng-click="deleteLocation(location.name)"></span></li>' +
                       '</ul>' +
                       '<div class="sub-header">OR CHOOSE FROM TOP CITIES</div>' +
                       '<ul class="choose-location">' +
                           '<li ng-repeat="location in topLocations" ng-click="addLocation(location)">{{location}}</li>' +
                       '</ul>'
        };
    });