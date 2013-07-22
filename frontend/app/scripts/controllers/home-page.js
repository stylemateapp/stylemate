'use strict';

function HomePageController($scope, $http, serverUrl) {

    $http.get(serverUrl + '/user/location/')
        .success(function (response) {


        });

}

SignUpController.$inject = ['$scope', '$http', 'serverUrl'];