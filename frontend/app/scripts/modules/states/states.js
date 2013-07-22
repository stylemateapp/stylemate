'use strict';

angular.module('stylemate.states', ['ui.state'])

    .config(['$stateProvider', function($stateProvider) {

        var homePage = {
            name: 'homepage',
            url: '/homepage',
            templateUrl: 'app/views/home-page.html',
            controller: HomePageController
        };

        $stateProvider.state(homePage);

        var login = {
            name: 'login',
            url: '/login',
            templateUrl: 'app/views/login.html',
            controller: LoginController
        };

        $stateProvider.state(login);

        var signUp = {
            name: 'sign-up',
            url: '/sign-up',
            templateUrl: 'app/views/sign-up.html',
            controller: SignUpController
        };

        $stateProvider.state(signUp);
    }]);