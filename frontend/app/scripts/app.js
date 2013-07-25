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

    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('homepage');

    }])

    .run([
        '$rootScope', '$http', '$state', '$stateParams', 'GeoLocationService', 'serverUrl',
        function ($rootScope, $http, $state, $stateParams, GeoLocationService, serverUrl) {

            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

            $rootScope.goTo = function (state) {

                $state.transitionTo(state);
            };

            $rootScope.checkUserProfileCompleteness = function () {

                $http.get(serverUrl + '/user/getLocation/')

                    .success(function (data, status, error, config) {

                        $rootScope.checkUserStyles();
                    })

                    .error(function (data, status, error, config) {

                        $state.transitionTo('set-location');
                    });
            };

            $rootScope.checkUserStyles = function () {

                $http.get(serverUrl + '/user/getStyles/')

                    .success(function (data, status, error, config) {

                        if (!data.selectedStyles.length) {

                            $state.transitionTo('choose-styles');
                        }
                    })

                    .error(function (data, status, error, config) {

                        $state.transitionTo('choose-styles');
                    });
            };

            $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {

                if (toState.name != 'sign-up') {

                    $rootScope.checkUserProfileCompleteness();
                }
            });
    }]);