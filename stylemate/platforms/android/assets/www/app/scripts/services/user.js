'use strict';

var app = angular.module('stylemate.services', []);

app.factory('UserService', ['$rootScope', '$http', '$q', '$state', 'serverUrl', function ($rootScope, $http, $q, $state, serverUrl) {

        function UserService() {

        }

        UserService.prototype.getLocations = function() {

            var deferred = $q.defer();

            $http.get(serverUrl + '/user/getLocations/')

                .success(function (data) {

                    deferred.resolve(data.locations);
                })

                .error(function () {

                    $state.transitionTo('set-location');
                });

            return deferred.promise;
        };

        UserService.prototype.getStyles = function () {

            var deferred = $q.defer();

            $http.get(serverUrl + '/user/getStyles/')

                .success(function (data) {

                    if (!data.selectedStyles.length) {

                        $state.transitionTo('choose-styles');
                    }
                    else {

                        $rootScope.loggedIn = true;
                    }

                    deferred.resolve(data);
                })

                .error(function () {

                    $state.transitionTo('choose-styles');
                });

            return deferred.promise;
        };

        return new UserService();
    }]);