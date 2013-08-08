'use strict';

angular.module('stylemate', ['ui.state', 'stylemate.states', 'stylemate.login', 'stylemate.services', 'stylemate.directives'])

    .constant('serverUrl', 'http://lastdayz.ru/stylemate')
    .constant('imagePath', 'http://lastdayz.ru/stylemate/uploads/')
    .constant('imageWidth', '640')

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

    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('homepage');

    }])

    .run([
        '$rootScope', '$http', '$state', '$stateParams', 'serverUrl',
        function ($rootScope, $http, $state, $stateParams, serverUrl) {

            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

            $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){

                $rootScope.previousStateName = fromState.name;
            });

            $rootScope.goTo = function (state) {

                $state.transitionTo(state);
            };

            $rootScope.logOut = function () {

                $http.get(serverUrl + '/user/logout')

                    .success(function () {

                        $state.transitionTo('login');
                    });
            };

            $rootScope.goToHomepage = function () {

                $state.transitionTo('homepage');
            };
    }]);