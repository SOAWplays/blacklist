var registerApp = angular.module('registrationApp', ['vcRecaptcha'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

registerApp.factory('Login', function($http) {
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

registerApp.filter('safe', ['$sce', function($sce) {
  return function(html){
    return $sce.trustAsHtml(html);
  }
}]);

registerApp.controller('registrationManager', function($scope, $timeout, $interval, Login) {
    $scope.alert = {
        style: 'success',
        visible: false, 
        content: 'foo'
    };
    $scope.auth = { };
    
    $scope.submit = function(token) {
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
                redirect: location.href,
                success: false 
            }, 2500);
        })
    };
    
    $scope.showAlert = function(content, duration) {
        $scope.alert.style = content.success ? 'success' : 'danger';
        var redirect = content.redirect;
        $scope.alert.visible = true;
        
        if(typeof redirect !== 'undefined') {
            var passed = 0;
            $timeout(function() {
                $scope.alert.content = 'Redirecting you now...';
            }, duration);
        }
        
        $timeout(function() {
            $scope.alert.visible = false;
        }, duration - 250);
    };
});