var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate','ngSanitize', 'selectionModel']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/details', {
      title: 'details',
      templateUrl: 'partials/details.php',
      controller: 'portalCtrl',
      resolve: {
        user : function(){
          return 0; 
        }
      }}).
    when('/', {
      title: 'Home',
      templateUrl: 'partials/students.php',
      controller: 'portalCtrl',
      resolve: {
        user : function(auth){
          return auth.getUserData();
        }
      }
    })
    .otherwise({
      redirectTo: '/'
    });
}]);