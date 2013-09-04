// from https://github.com/lavinjj/angularjs-spinner/blob/master/sample01/app/app.js

'use strict';

angular
    .module('stylemate')

    .config(['$httpProvider', 'eventStartRequest', 'eventEndRequest', function ($httpProvider, eventStartRequest, eventEndRequest) {
        var $http,
        interceptor = ['$q', '$injector', function ($q, $injector) {

            var rootScope;

            function success(response) {

                // get $http via $injector because of circular dependency problem

                $http = $http || $injector.get('$http');

                // don't send notification until all requests are complete

                if ($http.pendingRequests.length < 1) {

                    // get $rootScope via $injector because of circular dependency problem

                    rootScope = rootScope || $injector.get('$rootScope');

                    // send a notification requests are complete

                    rootScope.$broadcast(eventEndRequest);
                }

                return response;
            }

            function error(response) {

                // get $http via $injector because of circular dependency problem

                $http = $http || $injector.get('$http');

                // don't send notification until all requests are complete

                if ($http.pendingRequests.length < 1) {

                    // get $rootScope via $injector because of circular dependency problem

                    rootScope = rootScope || $injector.get('$rootScope');

                    // send a notification requests are complete

                    rootScope.$broadcast(eventEndRequest);
                }

                return $q.reject(response);
            }

            return function (promise) {

                // get $rootScope via $injector because of circular dependency problem

                rootScope = rootScope || $injector.get('$rootScope');

                // send notification a request has started

                rootScope.$broadcast(eventStartRequest);

                return promise.then(success, error);
            }
        }];

    $httpProvider.responseInterceptors.push(interceptor);
}]);