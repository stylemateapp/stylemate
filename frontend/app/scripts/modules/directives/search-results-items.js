angular.module('stylemate.directives')

    .directive('searchResultsItems', function() {
        return {
            restrict: 'EA',
            replace: true,
            link: function (scope, element, attrs) {

                element.bind('click', function () {

                    angular.element(element).toggleClass('show');
                });

                angular.element(document).bind('click', function (event) {

                    var shouldOpen = (event.target == element[0]);

                    if(!shouldOpen) {

                        element.removeClass('show');
                    }
                });
            },
            template:  '<section class="shop-look" id="shop-look" tabindex="1" ng-show="selected.items" ng-click="clickShopThisLook()">' +
                        '<ul class="clothing-items">' +
                            '<li ng-repeat="(name, item) in selected.items" ng-click="showItemsBlock(item)">{{name}}</li>' +
                        '</ul>' +
                    '</section>'
        };
    });