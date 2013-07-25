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

        var setLocation = {
            name: 'set-location',
            url: '/set-location',
            templateUrl: 'app/views/set-location.html',
            controller: SetLocationController
        };

        $stateProvider.state(setLocation);

        var chooseStyles = {
            name: 'choose-styles',
            url: '/choose-styles',
            templateUrl: 'app/views/choose-styles.html',
            controller: ChooseStylesController
        };

        $stateProvider.state(chooseStyles);
    }]);