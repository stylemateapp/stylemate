'use strict';

function ForgotPasswordController($scope, $state, FacebookService) {

    $scope.errorMessage = '';

    $scope.goNext = function () {

        $state.transitionTo('forgot-password-part-two');
    };

    $scope.gatherFacebookInfo = function () {

        FacebookService.init();

        $scope.$on('event:gatheredFacebookData', function () {

            $scope.goNext();
        });
    };
}

ForgotPasswordController.$inject = ['$scope', '$state', 'FacebookService'];