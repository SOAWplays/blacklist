var pluginApp = angular.module('pluginApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

pluginApp.factory('ProtectionInterceptor', function () {
    return {
        request: function (config) {
            var elems = $('meta[name=X-CSRF-Token]');
            if(elems.length > 0) {
                config.headers['X-CSRF-Token'] = $('meta[name=X-CSRF-Token]')[0].attributes.content.value;
            }
            return config;
        }
    };
});

pluginApp.config(function($httpProvider) {
    $httpProvider.interceptors.push('ProtectionInterceptor');
});

pluginApp.factory('Plugins', function($http) {
    return {
        get : function(page) {
            if(typeof page === 'undefined') page = 1;
            return $http.get(location.protocol + '//' + location.host + '/api/plugins?page=' + page);
        }
    }
});

pluginApp.controller('pluginManager', function($scope, $http, Plugins, $timeout, $interval) {
    $scope.nextPageEmpty = false;
    $scope.loading = false;
    $scope.error = false;
    $scope.plugins = [];
    $scope.pages = [];
    $scope.total = 0;
    $scope.page = 1;
    
    $scope.getPlugins = function() {
        $scope.loading = true;
        
        var promise = Plugins.get($scope.page);
        promise.success(function(data) {
            $timeout(function() {
                if(data.data.length == 0) {
                    $timeout(function() {
                        $scope.nextPageEmpty = false;
                    }, 5000);
                    
                    $scope.nextPageEmpty = true;
                    $scope.page = $scope.oldPage;
                    return;    
                }
                
                $scope.pages = [];
    			for(var i = 1; i <= data.last_page; i++) {
    			    $scope.pages.push(i);    
    			}
    			
                $scope.plugins = data.data;
    			$scope.loading = false;
    			
    			var delay = 128;
    			if (data.total > 32 && data.total <= 64) {
    			    delay = 64;
    			} else if (data.total > 64 && data.total <= 128) {
    			    delay = 32;
    			} else if (data.total > 128 && data.total <= 256) {
                    delay = 16;
    			} else if (data.total > 256) {
    			    delay = 8;
    			}
    			
    			var intervalPromise = $interval(function() {
    			    if($scope.total < data.total) {
    			        $scope.total++;
    			    } else {
    			        $interval.cancel(intervalPromise);
    			    }
    			}.bind(this), delay);
    		}, 280);
        });
        
        promise.error(function() {
            $scope.loading = false;
            $scope.error = true;
        });
    };
    
    $scope.nextPage = function() {
        if($scope.page < $scope.pages) {
            $scope.goto($scope.page + 1);
        }
    };
    
    $scope.previousPage = function() {
        if($scope.page >= 1) {
            $scope.goto($scope.page - 1);
        }
    };
    
    $scope.goto = function(page) {
        $scope.oldPage = $scope.page;
        $scope.page = page;
        $scope.getPlugins();
    };
    
    $scope.getPlugins();
});