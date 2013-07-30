'use strict';

function ChooseOccasionController($scope, $http,  $state, Search, serverUrl) {

    $scope.errorMessage = '';
    $scope.cloudyClass = Search.getParam('cloudyClass');

    if(!Search.isValidForOccasionPage()) {

        $scope.errorMessage = 'Not all required params are set. Try to go to homepage.';
    }

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

        Search.setParam('occasion', id);
        $state.transitionTo('search-results');
    };
}

ChooseOccasionController.$inject = ['$scope', '$http', '$state', 'Search', 'serverUrl'];