'use strict';

angular.module('stylemate', ['ui.state', 'stylemate.states', 'stylemate.login'])

    // hack to disable auto scrolling on hashchange because we're using ui-router to manage states,
    // instead of the core angular router which cannot handle states

    // discussion on this here: https://github.com/angular-ui/ui-router/issues/110

    //.value('$anchorScroll', angular.noop)

    .constant('serverUrl', 'http://lastdayz.ru/stylemate')

    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('homepage');

    }])

    .run(['$rootScope', '$http', '$state', '$stateParams', 'serverUrl', function ($rootScope, $http, $state, $stateParams, serverUrl) {

        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;

        $rootScope.goTo = function (state) {

            $state.transitionTo(state);
        };

        $rootScope.checkUserLocation = function () {

            $http.get(serverUrl + '/user/getLocation/')

                .success(function (data, status, error, config) {

                    $rootScope.checkUserStyles();
                })

                .error(function (data, status, error, config) {

                    $state.transitionTo('set-location');
                });
        };

        $rootScope.checkUserStyles = function () {

            // TODO

        };

        $rootScope.checkUserLocation();


        /*$rootScope.isAnythingLoading = function () {

            return $http.pendingRequests.length > 0;
        };*/
    }]);