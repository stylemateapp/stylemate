angular.module('stylemate.directives')

    .directive('ajaxLoader', ['$rootScope', 'eventStartRequest', 'eventEndRequest', function ($rootScope, eventStartRequest, eventEndRequest) {
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
            }
        };
    }]);