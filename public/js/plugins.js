var pluginApp = angular.module('pluginApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

pluginApp.factory('ProtectionInterceptor', function () {
    return {
        request: function (config) {
            config.headers['X-CSRF-Token'] = $('meta[name=X-CSRF-Token]')[0].attributes.content.value;
            return config;
        }
    };
});

pluginApp.config(function($httpProvider) {
    $httpProvider.interceptors.push('ProtectionInterceptor');
});

pluginApp.factory('Plugins', function($http) {
    return {
        get : function() {
            return $http.get(location.protocol + '//' + location.host + '/api/plugins');
        }
    }
});

pluginApp.controller('pluginManager', function($scope, $http, Plugins, $timeout, $interval) {
    $scope.loading = false;
    $scope.error = false;
    $scope.plugins = [];
    $scope.total = 0;
    
    $scope.getPlugins = function() {
        $scope.loading = true;
        
        var promise = Plugins.get();
        promise.success(function(data) {
            $timeout(function() {
                $scope.plugins = data.data;
                $scope.total = data.total;
    			$scope.loading = false;
    		}, 1500);
        });
        
        promise.error(function() {
            $scope.loading = false;
            $scope.error = true;
        });
    };
    
    /*
    $interval(function() {
        $scope.getPlugins();
    }.bind(this), 10000);
    */
    $scope.getPlugins();
});