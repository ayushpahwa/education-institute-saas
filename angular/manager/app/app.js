var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate','ngFileUpload']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider
    
    // Adminstrator
    .when('/students', {
      title: 'students',
      templateUrl: 'partials/adminstrator/students.php',
      controller: 'studentsCtrl'
    })
    .when('/enquiries', {
      title: 'Enquiries',
      templateUrl: 'partials/adminstrator/enquiries.html',
      controller: 'enquiriesCtrl'
    })
    .when('/notifications', {
      title: 'Nortifications',
      templateUrl: 'partials/adminstrator/notifications.html',
      controller: 'notificationsCtrl'
    })
    
    // Management
    .when('/classes', {
      title: 'Classes',
      templateUrl: 'partials/management/classes.html',
      controller: 'classesCtrl'
    })
    .when('/batches', {
      title: 'Batches',
      templateUrl: 'partials/management/batches.html',
      controller: 'batchesCtrl'
    })
    .when('/subjects', {
      title: 'Subjects',
      templateUrl: 'partials/management/subjects.html',
      controller: 'subjectsCtrl'
    })

    // Teacher
    .when('/assignment', {
      title: 'Students',
      templateUrl: 'partials/teacher/assignment.html',
      controller: 'assignmentCtrl'
    })
    .when('/attendance', {
      title: 'Students',
      templateUrl: 'partials/teacher/attendence.php',
      controller: 'attendenceCtrl'
    })
    .when('/attendenceView', {
      title: 'Attendance View',
      templateUrl: 'partials/teacher/attendenceView.php',
      controller: 'attendenceViewCtrl'
    })
    .when('/showTest', {
      title: 'View Test Results ',
      templateUrl: 'partials/teacher/showTest.html',
      controller: 'showTestCtrl'
    })
    .when('/test', {
      title: 'Add new Test',
      templateUrl: 'partials/teacher/test.php',
      controller: 'testCtrl'
    })
    .when('/view', {
      title: 'Test View',
      templateUrl: 'partials/teacher/testView.php',
      controller: 'testViewCtrl'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);
    