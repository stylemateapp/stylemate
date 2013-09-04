angular.module('stylemate.directives')

    .directive('ajaxLoader', [
        '$rootScope', 'eventStartRequest', 'eventEndRequest', 'eventStartLoadingData', 'eventEndLoadingData',
        function ($rootScope, eventStartRequest, eventEndRequest, eventStartLoadingData, eventEndLoadingData) {
        return {
            restrict: 'EA',
            link: function (scope, element, attrs) {

                $rootScope.$on('$stateChangeStart', function () {

                    element.addClass('show');
                });

                $rootScope.$on('$stateChangeSuccess', function () {

                    element.removeClass('show');
                });

                $rootScope.$on(eventStartRequest, function () {

                    element.addClass('show');
                });

                $rootScope.$on(eventEndRequest, function () {

                    element.removeClass('show');
                });

                $rootScope.$on(eventStartLoadingData, function () {

                    element.addClass('show');
                });

                $rootScope.$on(eventEndLoadingData, function () {

                    element.removeClass('show');
                });
            }
        };
    }]);