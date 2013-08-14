'use strict';

angular.module('stylemate.services', []).

    factory('GeoLocationService', ['$http', 'serverUrl', function ($http, serverUrl) {

        return new GeoLocationService($http, serverUrl);
    }]);

var GeoLocationService = (function () {

    var geoCoder;

    function GeoLocationService($http, serverUrl) {

        this.$http = $http;
        this.serverUrl = serverUrl;
    }

    GeoLocationService.initializeGeoLocation = function() {

        geoCoder = new google.maps.Geocoder();

        if (navigator.geolocation) {

            setTimeout(function() {navigator.geolocation.getCurrentPosition(successFunction, errorFunction);}, 2000);
        }

        function codeLatLng(lat, lng) {

            var latlng = new google.maps.LatLng(lat, lng);

            geoCoder.geocode({'latLng': latlng}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {

                    if (results[1]) {

                        for (var i = 0; i < results[0].address_components.length; i++) {

                            for (var b = 0; b < results[0].address_components[i].types.length; b++) {

                                if (results[0].address_components[i].types[b] == "locality") {

                                    var city = results[0].address_components[i];
                                    break;
                                }
                            }
                        }

                        // @TODO: fix this with using of Deferred API

                        if(city.long_name !== '') {

                            var scope = angular.element(document.getElementById('location')).scope();

                            if(scope) {

                                scope.location = city.long_name;
                                scope.$apply();
                            }
                        }
                    }
                }
            });
        }

        function successFunction(position) {

            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            codeLatLng(lat, lng);
        }

        function errorFunction() {
        }
    };

    return GeoLocationService;
})();


//google.maps.event.addDomListener(window, 'load', GeoLocationService.initializeGeoLocation);