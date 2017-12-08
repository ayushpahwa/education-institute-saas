var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate', 'ngFileUpload']);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider

            .when('/teachers', {
                title: 'Teachers',
                templateUrl: 'partials/teachers.html',
                controller: 'teachersCtrl'

            })
            .when('/managers', {
                title: 'managers',
                templateUrl: 'partials/managers.html',
                controller: 'managersCtrl'
            })
            .when('/classes', {
                title: 'Classes',
                templateUrl: 'partials/classes.html',
                controller: 'classesCtrl'
            })
            .when('/batches', {
                title: 'Batches',
                templateUrl: 'partials/batches.html',
                controller: 'batchesCtrl'
            })
            .when('/subjects', {
                title: 'Subjects',
                templateUrl: 'partials/subjects.html',
                controller: 'subjectsCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
]);
