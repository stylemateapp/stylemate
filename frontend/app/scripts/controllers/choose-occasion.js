'use strict';

function ChooseOccasionController($scope,  $state, Search, userInfo) {

    $scope.errorMessage = '';
    $scope.cloudyClass = Search.getParam('cloudyClass');

    Search.setParam('occasion', -1);

    if(!Search.isValidForOccasionPage()) {

        $scope.errorMessage = 'Not all required params are set. Try to go to homepage.';
    }
    else {

        $scope.occasions = userInfo.occasions;

        $scope.toggleOccasion = function (id) {

            angular.element(document.getElementById('occasion-' + id)).toggleClass('selected');

            Search.setParam('occasion', id);
            $state.transitionTo('search-results');
        };
    }
}

ChooseOccasionController.$inject = ['$scope', '$state', 'Search', 'userInfo'];