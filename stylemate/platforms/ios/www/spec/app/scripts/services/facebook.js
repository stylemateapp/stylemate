'use strict';

var app = angular.module('stylemate.services');

app.factory('FacebookService', ['$rootScope', function ($rootScope) {

    var FacebookService = {};

    FacebookService.email = '';
    FacebookService.name = '';

    var my_client_id = "684349924916237",
        my_secret = "c44f68526bd887a7c26326d43ef97cb5",
        my_redirect_uri = "https://www.facebook.com/connect/login_success.html",
        my_type = "user_agent", my_display = "touch";
    var ref;
    var token;

    FacebookService.init = function () {

        var authorize_url = "https://www.facebook.com/dialog/oauth?";
        authorize_url += "client_id=" + my_client_id;
        authorize_url += "&redirect_uri=" + my_redirect_uri;
        authorize_url += "&display=" + my_display;
        authorize_url += "&scope=email";

        ref = window.open(authorize_url, '_blank', 'location=no');

        ref.addEventListener('loadstart', function (event) {

            this.facebookLocChanged(event.url);
        });
    };

    FacebookService.facebookLocChanged = function (loc) {

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
                                    this.email = data.email;
                                    this.name = data.name;

                                    $rootScope.$broadcast('event:gatheredFacebookData');

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
    };

    return FacebookService;
}]);