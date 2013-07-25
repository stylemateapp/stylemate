angular.module('stylemate.directives', []).

    directive('focusElement', function () {

    return function (scope, element) {

        element[0].focus();
    };
});