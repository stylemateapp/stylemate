angular.module('stylemate.directives')

    .directive('settingsMenu', function() {
        return {
            restrict: 'EA',
            replace: true,
            link: function (scope, element, attrs) {

                element.bind('click', function () {

                    angular.element(element).toggleClass('show');
                });

                angular.element(document).bind('click', function (event) {

                    var shouldOpen = (event.target == element[0]);

                    if(!shouldOpen) {

                        element.removeClass('show');
                    }
                });
            },
            template:  '<nav class="settings" tabindex="0">' +
                '<ul class="settings-submenu needsclick">' +
                    '<li><a href="#/set-location">EDIT LOCATIONS</a></li>' +
                    '<li><a href="#/choose-styles">EDIT STYLES</a></li>' +
                    '<li><a ng-click="logOut()">LOGOUT</a></li>' +
                '</ul>' +
            '</nav>'
        };
    });