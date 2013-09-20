'use strict';

function ChooseOccasionController($scope, $state, Search, userInfo) {

    $scope.errorMessage = '';
    $scope.cloudyClass = Search.getParam('cloudyClass');

    Search.setParam('occasion', -1);

    if(!Search.isValidForOccasionPage()) {

        $scope.goToHomepage();

        $scope.errorMessage = 'Not all required params are set. Going back to homepage, please wait...';
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