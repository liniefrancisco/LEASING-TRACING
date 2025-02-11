
'use strict';
angular
  .module('app')

    .directive("isUnique", ["$http", function($http) {
        return {
            require: 'ngModel',
            restrict: 'A',
            link: function(scope, elem, attrs, ctrl) {

                // check that a valid api end point is provided
                if (typeof attrs.isUniqueApi === "undefined" || attrs.isUniqueApi === ""){
                    throw new Error("Missing api end point; use is-unique-api to define the end point");
                }

                // set a watch on the value of the field
                scope.$watch(function () {
                    return ctrl.$modelValue;
                }, function(currentValue) {

                    // when the field value changes
                    // send an xhr request to determine if the value is available
                    var url = attrs.isUniqueApi;
                    if (typeof currentValue !== 'undefined') {
                        url = url + currentValue;
                        // alert(url);
                        // elem.addClass('loading');
                        $http.get(url).success(function(data) {

                            // data = data.substr(2);
                            // elem.removeClass('loading');
                            ctrl.$setValidity('unique', !data);
                        }).error(function() {
                            elem.removeClass('loading');
                        });
                    }
                });
            }
        };
    }])

    .directive("passwordVerify", function() {
       return {
          require: "ngModel",
          scope: {
            passwordVerify: '='
          },
          link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;

                if (scope.passwordVerify || ctrl.$viewValue) {
                   combined = scope.passwordVerify + '_' + ctrl.$viewValue; 
                   // alert(combined);
                }

                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
         }
       };
    });

