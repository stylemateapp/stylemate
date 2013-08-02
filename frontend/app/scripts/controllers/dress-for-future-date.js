'use strict';

function DressForFutureDateController($scope, $http, $state, Search) {

    $scope.errorMessage = '';
    $scope.dates = [
        {'id': 0, 'name': moment().format('dddd')},
        {'id': 1, 'name': moment().add('days', 1).format('dddd')},
        {'id': 2, 'name': moment().add('days', 2).format('dddd')},
        {'id': 3, 'name': moment().add('days', 3).format('dddd')},
        {'id': 4, 'name': moment().add('days', 4).format('dddd')},
        {'id': 5, 'name': moment().add('days', 5).format('dddd')},
        {'id': 6, 'name': moment().add('days', 6).format('dddd')}
    ];

    $scope.selectDate = function(id) {

        Search.setParam('date', id);
        $state.transitionTo('choose-occasion');
    }
}

DressForFutureDateController.$inject = ['$scope', '$http', '$state', 'Search'];