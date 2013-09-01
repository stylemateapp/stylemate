'use strict';

function SearchResultsController($scope, $http,  $state, Search, serverUrl, imagePath, imageWidth) {

    $scope.errorMessage = '';
    $scope.imagePath = imagePath;
    $scope.imageWidth = imageWidth;
    $scope.imageKeys = [];
    $scope.images = {};
    $scope.selectedIndex = 0;
    $scope.arrayIndex = 0;
    $scope.querySuccess = false;
    $scope.showItems = false;

    if (!Search.isValid()) {

        $scope.errorMessage = 'Not all required params are set. Try to go to homepage.';
    }
    else {

        // @TODO: This should be directive..

        $http.get(serverUrl + '/user/getImages?occasion=' + Search.getParam('occasion') + '&temperature=' + Search.getParam('temperature') + '&date=' + Search.getParam('date'))

            .success(function (data) {

                if (data.success === true) {

                    $scope.querySuccess = true;

                    $scope.images = data.images;
                    $scope.imageKeys = Object.keys(data.images);
                    $scope.arrayIndex = 0;

                    var key = $scope.imageKeys[$scope.arrayIndex];

                    $scope.selected = data.images[key];
                    $scope.selectedIndex = key;
                }
                else {

                    $scope.errorMessage = 'No results for your query :( Try other parameters please.';
                }
            })

            .error(function () {

                $scope.errorMessage = 'No results for your query :( Try other parameters please.';
            });

        $scope.goNext = function () {

            $scope.selectedIndex = $scope.selectedIndex + 1;
            $scope.arrayIndex++;

            var key = $scope.imageKeys[$scope.arrayIndex];

            $scope.selected = $scope.images[key];
            $scope.selectedIndex = key;

            $scope.listPosition = {left: ($scope.imageWidth * $scope.arrayIndex * -1) + "px"};
        };

        $scope.goPrevious = function () {

            $scope.selectedIndex = $scope.selectedIndex - 1;
            $scope.arrayIndex--;

            var key = $scope.imageKeys[$scope.arrayIndex];

            $scope.selected = $scope.images[key];
            $scope.selectedIndex = key;

            $scope.listPosition = {left: ($scope.imageWidth * $scope.arrayIndex * -1) + "px"};
        };

        $scope.showItemsBlock = function(item) {

            $scope.showItems = true;
            $scope.items = item;
        };

        $scope.goBack = function() {

            if(!$scope.showItems) {

                $scope.goTo('choose-occasion');

            }
            else {

                $scope.showItems = false;
            }
        };
    }
}

SearchResultsController.$inject = ['$scope', '$http', '$state', 'Search', 'serverUrl', 'imagePath', 'imageWidth'];