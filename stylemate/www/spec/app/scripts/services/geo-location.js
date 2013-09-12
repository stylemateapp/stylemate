'use strict';

angular.module('stylemate.services').

    factory('GeoLocationService', ['$rootScope', function ($rootScope) {

        // from http://stackoverflow.com/questions/8068052/phonegap-detect-if-running-on-desktop-browser

        var isPhoneGap = function () {

            // will fail on localhost - but in case of using remote server for development it's ok

            return /^file:\/{3}[^\/]/i.test(window.location.href)
                && /ios|iphone|ipod|ipad|android/i.test(navigator.userAgent);
        };

        var geoFunction = function () {

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(

                    function (position) {

                        $rootScope.geoLocation.enabled = true;
                        $rootScope.geoLocation.position = position;
                    });
            }
        };

        function run() {

            $rootScope.geoLocation = {enabled: false};

            $rootScope.$apply(function () {

                if (isPhoneGap()) {

                    document.addEventListener('deviceready', function () {

                        geoFunction();

                    }, false);
                }
                else {

                    geoFunction();
                }
            });
        }

        return run();
    }]);