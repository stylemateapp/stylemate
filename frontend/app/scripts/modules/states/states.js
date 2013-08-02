'use strict';

angular.module('stylemate.states', ['ui.state'])

    .config(['$stateProvider', function($stateProvider) {

        var resolveLocationAndStyle = {

            userLocations: ['UserService', function (UserService) {

                return UserService.getLocations();
            }],
            userStyles: ['UserService', function (UserService) {

                return UserService.getStyles();
            }]
        };

        var homePage = {
            name: 'homepage',
            url: '/homepage',
            templateUrl: 'app/views/home-page.html',
            resolve: resolveLocationAndStyle,
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

        var chooseOccasion = {
            name: 'choose-occasion',
            url: '/choose-occasion',
            templateUrl: 'app/views/choose-occasion.html',
            resolve: resolveLocationAndStyle,
            controller: ChooseOccasionController
        };

        $stateProvider.state(chooseOccasion);

        var searchResults = {
            name: 'search-results',
            url: '/search-results',
            templateUrl: 'app/views/search-results.html',
            resolve: resolveLocationAndStyle,
            controller: SearchResultsController
        };

        $stateProvider.state(searchResults);

        var dressForFutureLocation = {
            name: 'dress-for-future-location',
            url: '/dress-for-future-location',
            templateUrl: 'app/views/dress-for-future-location.html',
            resolve: resolveLocationAndStyle,
            controller: DressForFutureLocationController
        };

        $stateProvider.state(dressForFutureLocation);

        var dressForFutureDate = {
            name: 'dress-for-future-date',
            url: '/dress-for-future-date',
            templateUrl: 'app/views/dress-for-future-date.html',
            resolve: resolveLocationAndStyle,
            controller: DressForFutureDateController
        };

        $stateProvider.state(dressForFutureDate);
    }]);