var myApp = angular.module('myApp', ['ngRoute']);

myApp.config(function ($interpolateProvider, $routeProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

    $routeProvider
        .when('/', {
            templateUrl: 'pages/main.html',
            controller: 'mainController'
        })
        .when('/edit/:num', {
            templateUrl: 'pages/edit.html',
            controller: 'editController'
        })
        .when('/profile', {
            templateUrl: 'pages/profile.html',
            controller: 'editProfileController'
        }).when('/profileImage', {
            templateUrl: 'pages/profileImage.html',
            controller: 'myCtrl'
        });
});

myApp.controller('mainController', ['$scope', '$filter', '$http', '$log', function($scope, $filter, $http, $log) {

    $scope.todoName = '';

    $http.get('api/v1/todos')
        .success(function (result) {
            $scope.todosPending = result.pending;
            $scope.todosCompleted = result.completed;

            console.log($scope.todosPending);
        })
        .error(function (data, status) {
            console.log(data);
        });

    $scope.addTodo = function () {
        $http.post('api/v1/todos', { todoName: $scope.todoName })
            .success(function (result) {
                $scope.todosPending = result.pending;
                $scope.todosCompleted = result.completed;
                $scope.f.todoName = ''
                $scope.todoName = '';
            })
            .error(function (data, status) {
                console.log(data);
            });
    }

    $scope.removeTodo = function ($id) {
        $http.delete('api/v1/todos/' + $id)
            .success(function (result) {
                $scope.todosPending = result.pending;
                $scope.todosCompleted = result.completed;
            })
            .error(function (data, status) {
                console.log(data);
            });
    }

    $scope.changeDoneState = function ($id) {
        $http.post('api/v1/todos/changeDoneState/' + $id)
            .success(function (result) {
                $scope.todosPending = result.pending;
                $scope.todosCompleted = result.completed;
            })
            .error(function (data, status) {
                console.log(data);
            });
    }

}]);

myApp.controller("filterctrl", function ($scope) {
    $scope.todosPending
});

myApp.controller('editController', ['$scope', '$http', '$log', '$routeParams', '$location', function($scope, $http, $log, $routeParams, $location) {

    $scope.num = $routeParams.num;

    $http.get('api/v1/todos/getTodo/' + $scope.num)
        .success(function (result) {
            $scope.todoNameEdit = result.todoName;
        })
        .error(function (data, status) {
            console.log(data);
        });

    $scope.editTodo = function ($id) {

        $http.put('api/v1/todos/' + $id, { todoName: $scope.todoNameEdit })
            .success(function (result) {
                $location.path('/').replace();
            })
            .error(function (data, status) {
                console.log(data);
            });
    }

}]);

myApp.controller('editProfileController', ['$scope', '$http', '$log', '$routeParams', '$location', function($scope, $http, $log, $routeParams, $location) {

    $http.get('api/v1/user/getProfile')
        .success(function (result) {
            $scope.userFullName = result[0].name;
        })
        .error(function (data, status) {
            console.log(data);
        });

    $scope.updateUser = function () {

        $http.post('api/v1/user/updateProfile', { name: $scope.userFullName })
            .success(function (result) {
                $scope.userLoggedInName = result[0].name;

                var myEl = angular.element( document.querySelector( '#userLoggedInName' ) );
                myEl.text(result[0].name);

                $location.path('/').replace();
            })
            .error(function (data, status) {
                console.log(data);
            });
    }

}]);

myApp.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

myApp.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
            .success(function(){
            })
            .error(function(){
            });
    }
}]);

myApp.controller('myCtrl', ['$scope', 'fileUpload', function($scope, fileUpload){

    $scope.uploadFile = function(){
        var file = $scope.myFile;
        console.log('file is ' + JSON.stringify(file));
        var uploadUrl = "/images/uploads";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };

}]);






