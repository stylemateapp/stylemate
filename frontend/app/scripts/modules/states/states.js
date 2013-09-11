'use strict';

angular.module('stylemate.states', ['ui.state'])

    .config(['$stateProvider', function($stateProvider) {

        var resolveUser = {

            userInfo: ['UserService', function (UserService) {

                return UserService.getInfo();
            }]
        };

        var homePage = {
            name: 'homepage',
            url: '/homepage',
            templateUrl: 'app/views/home-page.html',
            resolve: resolveUser,
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

        var forgotPassword = {
            name: 'forgot-password',
            url: '/forgot-password',
            templateUrl: 'app/views/forgot-password.html',
            controller: ForgotPasswordController
        };

        $stateProvider.state(forgotPassword);

        var forgotPasswordPartTwo = {
            name: 'forgot-password-part-two',
            url: '/forgot-password-part-two',
            templateUrl: 'app/views/forgot-password-part-two.html',
            controller: ForgotPasswordPartTwoController
        };

        $stateProvider.state(forgotPasswordPartTwo);

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

        var chooseOccasion = {
            name: 'choose-occasion',
            url: '/choose-occasion',
            templateUrl: 'app/views/choose-occasion.html',
            resolve: resolveUser,
            controller: ChooseOccasionController
        };

        $stateProvider.state(chooseOccasion);

        var searchResults = {
            name: 'search-results',
            url: '/search-results',
            templateUrl: 'app/views/search-results.html',
            resolve: resolveUser,
            controller: SearchResultsController
        };

        $stateProvider.state(searchResults);

        var dressForFutureDate = {
            name: 'dress-for-future-date',
            url: '/dress-for-future-date',
            templateUrl: 'app/views/dress-for-future-date.html',
            resolve: resolveUser,
            controller: DressForFutureDateController
        };

        $stateProvider.state(dressForFutureDate);
    }]);