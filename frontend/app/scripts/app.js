'use strict';

angular.module('stylemate', ['ui.state', 'stylemate.states', 'stylemate.login', 'stylemate.services', 'stylemate.directives'])

    .constant('serverUrl', 'http://lastdayz.ru/stylemate')

    .constant('topLocations',
        ['Atlanta',
        'Boston',
        'Chicago',
        'Dallas',
        'Washington DC',
        'Driven',
        'Jetset',
        'Las Vegas',
        'Los Angeles',
        'Miami',
        'National',
        'New York',
        'San Francisco'
    ])

    .config(['$urlRouterProvider', function ($urlRouterProvider) {

        $urlRouterProvider.otherwise('homepage');

    }])

    .run([
        '$rootScope', '$state', '$stateParams',
        function ($rootScope, $state, $stateParams) {

            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

            $rootScope.goTo = function (state) {

                $state.transitionTo(state);
            };
    }]);