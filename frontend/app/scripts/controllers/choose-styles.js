'use strict';

function ChooseStylesController($scope, $http, $state, serverUrl) {

    $scope.selectedStyles = [];
    $scope.errorMessage = '';

    $scope.$watch('errorMessage', function() {

        if($scope.errorMessage != '') {

            alert($scope.errorMessage);
        }
    });

    $http.get(serverUrl + '/user/getStyles')

        .success(function (data, status, error, config) {

            if (data.success === true) {

                $scope.styles = data.styles;
                $scope.selectedStyles = data.selectedStyles;
            }
            else {

                $scope.errorMessage = 'Error retrieving user styles. Check internet connection please.';
            }
        })

        .error(function (data, status, error, config) {

            $scope.errorMessage = 'Error retrieving user styles. Check internet connection please. Status Error: ' + status;
        });

    $scope.toggleStyle = function (id) {

        angular.element(document.getElementById('user-style-' + id)).toggleClass('selected');

        var newSelectedStyles = [];

        angular.forEach($scope.styles, function(value) {

            var elementId = value.id;

            if(angular.element(document.getElementById('user-style-' + elementId)).hasClass('selected')) {

                newSelectedStyles.push(value.id);
            }
        });

        $scope.selectedStyles = newSelectedStyles;
    };

    $scope.goToHomepage = function () {

        var styles = $scope.selectedStyles;

        $http.post(serverUrl + '/user/setStyles', {styles: styles})

            .success(function (data, status, error, config) {

                if (data.success === true) {

                    $state.transitionTo('homepage');

                }
                else {

                    $scope.errorMessage = data.errorMessage;
                }
            })

            .error(function (data, status, error, config) {

                $scope.errorMessage = data.errorMessage;
            });
    };

    $scope.goBack = function () {

        if ($scope.loggedIn) {

            $state.transitionTo('homepage');
        }
        else {

            $state.transitionTo('set-location');
        }
    };
}

ChooseStylesController.$inject = ['$scope', '$http', '$state', 'serverUrl'];