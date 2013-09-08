'use strict';

function SignUpController($scope, $http, $rootScope, $state, serverUrl) {

    $scope.errorMessage = '';

    $scope.goNext = function() {

        $http.post(serverUrl + '/user/signUp', {username: $scope.username, name: $scope.name, email: $scope.email, password: $scope.password})

            .success(function (data) {

                if (data.success === true) {

                    $scope.login();

                }
                else {

                    $scope.errorMessage = data.errorMessage;
                }
            })

            .error(function (data) {

                $scope.errorMessage = data.errorMessage;
            });

    };

    $scope.login = function () {

        $http.post(serverUrl + '/user/login', {username: $scope.username, password: $scope.password})

            .success(function (data) {

                if (data.success === true) {

                    $rootScope.$broadcast('event:loginSuccess');

                    if($rootScope.geoLocation.enabled) {

                        console.log($rootScope.geoLocation);

                        $http.post(
                            serverUrl + '/user/setDefaultLocation/', {
                                latitude: $rootScope.geoLocation.position.coords.latitude,
                                longitude: $rootScope.geoLocation.position.coords.longitude
                            })

                            .then(function () {

                                $state.transitionTo('choose-styles');
                            });
                    }
                    else {

                        $state.transitionTo('set-location');
                    }
                }
                else {

                    $scope.errorMessage = 'Error logging in using newly created user';
                }
            })

            .error(function () {

                $scope.errorMessage = 'Error logging in using newly created user';
            });
    };

    // @TODO Refactor this hell excluding it to separate service

    $scope.facebookLogin = function() {

        var my_client_id = "1410312039183601",
            my_secret = "c44f68526bd887a7c26326d43ef97cb5",
            my_redirect_uri = "https://www.facebook.com/connect/login_success.html",
            my_type = "user_agent", my_display = "touch";
        var ref;
        var token;

        var Facebook = {

            init: function () {

                var authorize_url = "https://www.facebook.com/dialog/oauth?";
                authorize_url += "client_id=" + my_client_id;
                authorize_url += "&redirect_uri=" + my_redirect_uri;
                authorize_url += "&display=" + my_display;
                authorize_url += "&scope=email";

                ref = window.open(authorize_url, '_blank', 'location=no');

                ref.addEventListener('loadstart', function (event) {

                    Facebook.facebookLocChanged(event.url);
                });
            },
            facebookLocChanged: function (loc) {

                if (loc.indexOf("code=") >= 1) {

                    var codeUrl = 'https://graph.facebook.com/oauth/access_token?client_id=' + my_client_id + '&client_secret=' + my_secret + '&redirect_uri=' + my_redirect_uri + '&code=' + loc.split("=")[1];
                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.open('GET', codeUrl, true);

                    xmlhttp.onreadystatechange = function () {

                        if (xmlhttp.readyState == 4) {

                            if (xmlhttp.status == 200) {

                                token = xmlhttp.responseText.split('=')[1].split('&')[0];

                                var dataUrl = 'https://graph.facebook.com/me/?access_token=' + token;
                                var xmlhttp2 = new XMLHttpRequest();

                                xmlhttp2.open('GET', dataUrl, true);

                                xmlhttp2.onreadystatechange = function () {

                                    if (xmlhttp2.readyState == 4) {

                                        if (xmlhttp2.status == 200) {

                                            var data = JSON.parse(xmlhttp2.responseText);
                                            $scope.email = data.email;
                                            $scope.name = data.name;

                                            $scope.$apply();

                                            ref.close();
                                        }
                                    }
                                    else {

                                        ref.close();
                                    }
                                };

                                xmlhttp2.send(null);
                            }
                        }
                        else {

                            ref.close();
                        }
                    };

                    xmlhttp.send(null);
                }
            }
        };

        Facebook.init();
    };
}

SignUpController.$inject = ['$scope', '$http', '$rootScope', '$state', 'serverUrl'];