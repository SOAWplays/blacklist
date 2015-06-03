var authApp = angular.module('authApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});  

var captcha = true;
try {
    angular.module('vcRecaptcha');
    authApp = angular.module('authApp', ['vcRecaptcha'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
} catch (err) {    
    captcha = false;
}

authApp.factory('Authenticator', function($http) {
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

authApp.filter('safe', ['$sce', function($sce) {
  return function(html){
    return $sce.trustAsHtml(html);
  }
}]);

authApp.controller('authManager', function($scope, $timeout, $interval, Authenticator) {
    $scope.reloading = false;
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
        
        var promise = Authenticator.postForm($scope.auth);
        promise.success(function(data) {
            $scope.alert.content = data.message;
            $scope.showAlert({
                redirect: data.redirect,
                success: true
            }, 3500);
        });
        
        promise.error(function(data) {
            console.log(data);
            if(data.fields) {
                var html = data.message += '<ul>';
                data.fields.forEach(function(el) {
                    if(el == 'confirm') {
                        html += '<li>password confirmation</li>';
                        return;
                    }
                    html += '<li>' + el + '</li>';
                });
                html += '</ul>';
                $scope.alert.content = html;
            } else {
                $scope.alert.content = data.message;
            }
            
            $scope.showAlert({
                success: false
            }, 6750);
        })
        
        promise.finally(function() {            
            $scope.loading = false;
        })
    };
    
    $scope.captcha = function(response) {
        $scope.reloading = false;
        $scope.auth.captcha = response;
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
                $scope.alert.content = 'Redirecting in <strong>' + (duration - passed) / 1000 + '</strong> seconds';
                passed = passed + 100;
            }.bind(this), 100);
        } 
        
        if (!content.success && captcha == true) {
            $scope.reloading = true;
            $timeout(function() {
                angular.injector(['ng', 'authApp']).get('vcRecaptchaService').reload();
                $scope.reloading = false;
            }, 1500);
        }
        
        $timeout(function() {
            $scope.alert.visible = false;
        }, duration - 250);
    };
});