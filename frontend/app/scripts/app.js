'use strict';

angular.module('stylemate', ['ui.state', 'ngMobile', 'stylemate.states', 'stylemate.login', 'stylemate.services', 'stylemate.directives', 'stylemate.filters'])

    .constant('serverUrl', 'http://stylemateapp.com')
    .constant('imagePath', 'http://i0.wp.com/stylemateapp.com/uploads/')
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

    .constant('eventStartRequest', 'event:startRequest')
    .constant('eventEndRequest', 'event:endRequest')
    .constant('eventStartLoadingData', 'event:startLoadingData')
    .constant('eventEndLoadingData', 'event:endLoadingData')

    .config(['$stateProvider', '$urlRouterProvider', '$httpProvider', function ($stateProvider, $urlRouterProvider, $httpProvider) {

        $urlRouterProvider.otherwise('homepage');

        $httpProvider.defaults.useXDomain = true;
        $httpProvider.defaults.withCredentials = true;
    }])

    .run([
        '$rootScope', '$http', '$state', '$stateParams', 'serverUrl', 'GeoLocationService',
        function ($rootScope, $http, $state, $stateParams, serverUrl, GeoLocationService) {

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