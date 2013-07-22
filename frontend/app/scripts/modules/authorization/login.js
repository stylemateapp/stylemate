'use strict';

angular
    .module('stylemate.login', ['ui.state'])

    .config(['$httpProvider', function ($httpProvider) {

        $httpProvider.responseInterceptors.push([

            '$rootScope', '$q',

            function (scope, $q) {

                return function (promise) {

                    return promise.then(success, error);
                };

                function success(response) {

                    return response;
                }

                function error(response) {

                    if (response.status == 401) {

                        var deferred = $q.defer();

                        scope.failedRequests.push({
                            config: response.config,
                            deferred: deferred
                        });

                        scope.$broadcast('event:loginRequired');

                        return deferred.promise;

                    }
                    else {

                        return $q.reject(response);
                    }
                }
            }
        ]);
    }])

    .run(['$rootScope', '$http', '$state', function ($rootScope, $http, $state) {

        $rootScope.failedRequests = [];
        $rootScope.loggedIn = false;
        $rootScope.user = '';

        $rootScope.$on('event:loginRequired', function () {

            $state.transitionTo('login');
        });


        $rootScope.$on('event:loginSuccess', function () {

            $rootScope.loggedIn = true;

            for (var i = 0; i < $rootScope.failedRequests.length; i++) {

                var request = $rootScope.failedRequests[i];

                $http(request.config).then(function (response) {

                    request.deferred.resolve(response);
                });
            }

            $rootScope.failedRequests = [];
        });
    }]);