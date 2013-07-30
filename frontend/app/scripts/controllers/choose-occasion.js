'use strict';

function ChooseOccasionController($scope, $http,  $state, Search, serverUrl) {

    $scope.selectedOccasion = -1;
    $scope.errorMessage = '';
    $scope.cloudyClass = Search.getParam('cloudyClass');

    $http.get(serverUrl + '/user/getOccasions')

        .success(function (data, status, error, config) {

            if (data.success === true) {

                $scope.occasions = data.occasions;
            }
            else {

                alert('Error retrieving occasions');
            }
        })

        .error(function (data, status, error, config) {

            alert('Error retrieving occasions');
        });

    $scope.toggleOccasion = function (id) {

        angular.element(document.getElementById('occasion-' + id)).toggleClass('selected');

        angular.forEach($scope.occasions, function (value) {

            var elementId = value.id;

            if(elementId != id) {

                angular.element(document.getElementById('occasion-' + elementId)).removeClass('selected');
            }
        });

        $scope.selectedOccasion = id;
    };
}

ChooseOccasionController.$inject = ['$scope', '$http', '$state', 'Search', 'serverUrl'];