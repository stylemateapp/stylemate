angular.module('stylemate.directives')

    .directive('chooseLocation', function () {
        return {
            restrict: 'EA',
            transclude: false,
            replace: false,
            scope: {
                'source': '='
            },
            controller: function ($scope, $element) {

                $scope.showing = true;

                $scope.setValue = function(value) {

                    $scope.location = value;
                    $scope.showing = false;
                };

                $element.bind('keyup', function (evt) {

                    $scope.$apply(function () {

                        $scope.handleKeypress.call($scope, evt.which);
                    });
                });

                $scope.handleKeypress = function (key) {

                    $scope.showing = true;
                };
            },
            template:  '<input type="text" class="text-field search-location" ng-model="location" name="location" id="location" placeholder="start typing" required focus-element>' +
                       '<div class="sub-header">OR CHOOSE FROM TOP CITIES</div>' +
                       '<ul class="choose-location" ng-show="showing">' +
                           '<li ng-repeat="location in source | filter:location" ng-click="setValue(location)">{{location}}</li>' +
                       '</ul>'
        };
    });