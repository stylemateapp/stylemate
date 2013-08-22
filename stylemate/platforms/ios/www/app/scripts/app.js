'use strict';

angular.module('stylemate', ['ui.state', 'stylemate.states', 'stylemate.login', 'stylemate.services', 'stylemate.directives'])

    .constant('serverUrl', 'http://lastdayz.ru/stylemate')
    .constant('imagePath', 'http://lastdayz.ru/stylemate/uploads/')
    .constant('imageWidth', '640')

    .constant('topLocations',
        ['Los Angeles',
        'San Francisco',
        'New York',
        'Chicago',
        'Miami',
        'Dallas',
        'London',
        'Paris',
        'Sydney'
    ])

    .config(['$stateProvider', '$urlRouterProvider', '$httpProvider', function ($stateProvider, $urlRouterProvider, $httpProvider) {

        $urlRouterProvider.otherwise('homepage');

        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
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