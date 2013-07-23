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

    .run(['$rootScope', '$http', '$state', '$stateParams', function ($rootScope, $http, $state, $stateParams) {

        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;

        $rootScope.goTo = function (state) {

            $state.transitionTo(state);
        };

        /*$rootScope.isAnythingLoading = function () {

            return $http.pendingRequests.length > 0;
        };*/
    }]);