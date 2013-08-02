'use strict';

var app = angular.module('stylemate.services');

app.factory('Search', [function () {

    function Search() {

        if (localStorage) {

            if (localStorage.getItem('searchParams')) {

                this.searchParams = JSON.parse(localStorage.getItem('searchParams'));
            }
            else {
                this.searchParams = {

                    temperature: -1000,
                    occasion: -1,
                    location: '',
                    date: 'today',
                    styles: {},
                    cloudyClass: ''
                }
            }
        }
        else {

            this.searchParams = {

                temperature: -1000,
                occasion: -1,
                location: '',
                date: 'today',
                styles: {},
                cloudyClass: ''
            }
        }
    }

    Search.prototype.setParam = function (key, value) {

        this.searchParams[key] = value;

        if (localStorage) {

            localStorage.setItem('searchParams', JSON.stringify(this.searchParams));
        }
    };

    Search.prototype.getParams = function() {

        return this.searchParams;
    };

    Search.prototype.getParam = function (key) {

        return this.searchParams[key];
    };

    Search.prototype.isValidForOccasionPage = function() {

        var valid = this.searchParams.temperature > -100 || typeof this.searchParams.temperature == 'string';
        valid = valid && this.searchParams.location != '';
        valid = valid && this.searchParams.date != '';
        valid = valid && this.searchParams.styles != {};

        return valid;
    };

    Search.prototype.isValid = function () {

        var valid = this.searchParams.temperature > -100 || typeof this.searchParams.temperature == 'string';
        valid = valid && this.searchParams.occasion > 0;
        valid = valid && this.searchParams.location != '';
        valid = valid && this.searchParams.date != '';
        valid = valid && this.searchParams.styles != {};

        return valid;
    };

    return new Search();
}]);