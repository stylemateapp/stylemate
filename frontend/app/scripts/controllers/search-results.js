'use strict';

function SearchResultsController($scope, $http, Search, serverUrl, imagePath, imageWidth) {

    $scope.errorMessage = '';
    $scope.imagePath = imagePath;
    $scope.imageWidth = imageWidth;
    $scope.imageKeys = [];
    $scope.images = {};
    $scope.selectedIndex = 0;
    $scope.arrayIndex = 0;
    $scope.querySuccess = false;
    $scope.showItems = false;

    $scope.imageHeight = document.documentElement.clientHeight <= 850 ? '724' : '900';

    alert($scope.imageHeight);

    function preload(images, callback) {

        var imageElements = [],
            counter = images.length,
            lfunc = function () {
                if (--counter === 0 && callback) callback(imageElements);
            };

        for (var i = 0, len = images.length; i < len; i++) {

            var img = new Image();
            imageElements.push(img);
            img.onload = lfunc;
            img.src = images[i];
        }
    }

    if (!Search.isValid()) {

        $scope.errorMessage = 'Not all required params are set. Going back to homepage, please wait...';
        $scope.goToHomepage();
    }
    else {

        $scope.locationName = Search.getParam('locationName');
        $scope.locationTemperature = Search.getParam('locationTemperature');
        $scope.cloudyClass = Search.getParam('cloudyClass');

        $http.get(serverUrl + '/user/getImages?occasion=' + Search.getParam('occasion') + '&temperature=' + Search.getParam('temperature') + '&date=' + Search.getParam('date'))

            .success(function (data) {

                if (data.success === true) {

                    var imagesArray = [];

                    for (var k in data.images) {

                        if (data.images[k].name) {

                            imagesArray.push(imagePath + data.images[k].name + '?h=' + $scope.imageHeight);
                        }
                    }

                    $scope.showPreLoader();

                    preload(imagesArray, function (preloadedImages) {

                        $scope.querySuccess = true;

                        $scope.images = data.images;
                        $scope.imageKeys = Object.keys(data.images);
                        $scope.arrayIndex = 0;

                        var key = $scope.imageKeys[$scope.arrayIndex];

                        $scope.selected = data.images[key];
                        $scope.selectedIndex = key;

                        $scope.$apply();

                        $scope.hidePreLoader();
                    });
                }
                else {

                    $scope.errorMessage = 'No results for your query :( Try other parameters please.';
                }
            })

            .error(function () {

                $scope.errorMessage = 'No results for your query :( Try other parameters please.';
            });

        $scope.isNext = function() {

            return $scope.querySuccess && $scope.selectedIndex != $scope.imageKeys[$scope.imageKeys.length - 1];
        };

        $scope.goNext = function () {

            if ($scope.isNext()) {

                $scope.selectedIndex = $scope.selectedIndex + 1;
                $scope.arrayIndex++;

                var key = $scope.imageKeys[$scope.arrayIndex];

                $scope.selected = $scope.images[key];
                $scope.selectedIndex = key;

                $scope.listPosition = {left: ($scope.imageWidth * $scope.arrayIndex * -1) + "px"};
            }
        };

        $scope.isPrevious = function () {

            return $scope.querySuccess && $scope.selectedIndex != $scope.imageKeys[0];
        };

        $scope.goPrevious = function () {

            if($scope.isPrevious()) {

                $scope.selectedIndex = $scope.selectedIndex - 1;
                $scope.arrayIndex--;

                var key = $scope.imageKeys[$scope.arrayIndex];

                $scope.selected = $scope.images[key];
                $scope.selectedIndex = key;

                $scope.listPosition = {left: ($scope.imageWidth * $scope.arrayIndex * -1) + "px"};
            }
        };

        $scope.showItemsBlock = function(item) {

            $scope.showItems = true;
            $scope.items = item;
        };

        $scope.isItemsListSmall = function() {

            return $scope.items && $scope.items.length <= 2;
        };

        $scope.goBack = function() {

            $scope.hidePreLoader();

            if(!$scope.showItems) {

                $scope.goTo('choose-occasion');
            }
            else {

                $scope.showItems = false;

                // This workaround is for preserve focus on popup menu with referenced items

                document.getElementById('shop-look').focus();
            }
        };

        $scope.facebookLink = function() {

            if ($scope.selected) {

                return 'https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=' + imagePath + $scope.selected.name + '&p[images][0]=' + imagePath + $scope.selected.name + '&p[title]=Stylemateapp&p[summary]=Like%20this%20look?%20Check%20it%20out%20on%20@Stylemateapp%20-%0Athe%20everyday%20style%20and%20weather%20companion%20for%20personalized%20fashion%20inspiration.';
            }

            return '';
        };

        $scope.twitterLink = function () {

            return 'https://twitter.com/intent/tweet?url=http://stylemateapp.com/&text=Like%20this%20look?%20Check%20it%20out%20on%20@Stylemateapp%20-%20the%20everyday%20style%20and%20weather%20companion%20for%20fashion%20inspiration.';
        };

        $scope.showPreLoader = function () {

            // Not true angularJS way, but deadlines, deadlines...

            angular.element(document.getElementById('loading-images-block')).addClass('show');
        };

        $scope.hidePreLoader = function () {

            // Not true angularJS way, but deadlines, deadlines...

            angular.element(document.getElementById('loading-images-block')).removeClass('show');
        };
    }
}

SearchResultsController.$inject = ['$scope', '$http', 'Search', 'serverUrl', 'imagePath', 'imageWidth'];