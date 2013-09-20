'use strict';

angular.module('stylemate.filters', []).

    filter('cutoff', function () {

        return function (input) {

            return input.split(',')[0];
        };
    });
