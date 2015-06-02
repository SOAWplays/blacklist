var loginApp = angular.module('loginApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

loginApp.factory('Login', function($http) {
    return {
        postForm : function(form) {
            return $http({
                method: 'POST',
                url: document.location,
                headers: {
                    'Content-Type': 'application/json'
                },
                data: form
            });
        }
    }    
});

loginApp.filter('safe', ['$sce', function($sce) {
  return function(html){
    return $sce.trustAsHtml(html);
  }
}]);

loginApp.controller('loginManager', function($scope, $timeout, $interval, Login) {
    $scope.loading = false;
    $scope.alert = {
        style: 'success',
        visible: false, 
        content: 'foo'
    };
    $scope.auth = { };

    $scope.submit = function(token) {
        $scope.auth._token = token;
        $scope.loading = true;
        
        var promise = Login.postForm($scope.auth);
        promise.success(function(data) {
            $scope.alert.content = data.message;
            $scope.showAlert({
                redirect: data.redirect,
                success: true
            }, 2500);
        });
        
        promise.error(function(data) {
            $scope.alert.content = data.message;
            if(data.failed) {
                var html = '<ul>';
                data.failed.forEach(function(el) {
                    html += '<li>' + el + '</li>';
                });
                html += '</ul>';
                $scope.alert.content = html;
            }
            $scope.showAlert({
                success: false 
            }, 2500);
        })
        
        promise.finally(function() {            $scope.loading = false;
        })
    };
    
    $scope.showAlert = function(content, duration) {
        $scope.alert.style = content.success ? 'success' : 'danger';
        var redirect = content.redirect;
        $scope.alert.visible = true;
        
        if(content.success && typeof redirect !== 'undefined') {
            var passed = 0;
            var intervalPromise = $interval(function() {
                var remaining = (duration - passed) / 1000;
                if(remaining == 0) {
                    $interval.cancel(intervalPromise);
                    $scope.alert.content = 'Redirecting you now...';
                    location.href = redirect;
                    return;
                }
                $scope.alert.content = 'Login successful, redirecting in <strong>' + (duration - passed) / 1000 + '</strong> seconds';
                passed = passed + 100;
            }.bind(this), 100);
        }
        
        $timeout(function() {
            $scope.alert.visible = false;
        }, duration - 250);
    };
});