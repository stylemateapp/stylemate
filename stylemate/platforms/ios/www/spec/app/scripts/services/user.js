'use strict';

var app = angular.module('stylemate.services', []);

app.factory('UserService', ['$rootScope', '$http', '$q', '$state', 'serverUrl', function ($rootScope, $http, $q, $state, serverUrl) {

    function UserService() {

    }

    UserService.prototype.getInfo = function () {

        var userInfo = $q.defer();

        $http.get(serverUrl + '/user/getUserInfo/').success(function (data) {

            if(!data.locations || !data.locations.default || !data.locations.default.name) {

                $state.transitionTo('set-location');
            }
            else if(!data.selectedStyles.length) {

                $state.transitionTo('choose-styles');
            }
            else {

                $rootScope.loggedIn = true;
                userInfo.resolve(data);
            }
        });

        return userInfo.promise;
    };

    return new UserService();
}]);