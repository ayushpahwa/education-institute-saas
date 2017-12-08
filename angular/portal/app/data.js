app.factory("Data", ['$http', '$location',
    function ($http, $q, $location) {

        var serviceBase = 'http://classroom.brinjal.in/v1/';

        var obj = {};

        obj.getbatch = function (q, Class, batch, subject) {
          return $http.get(serviceBase + q + '/' + Class + '/' + batch + '/' + subject).then(function (results) {
            return results.data;
          });
        };

        obj.getad = function (q, object) {
          return $http.get(serviceBase + q + '/' + object).then(function (results) {
            return results.data;
          });
        };

        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        return obj;
}]).factory("Data_2", ['$http',
function ($http) { // This service connects to our REST API

  var serviceBase = '//panel.brinjal.in/api/v2/';

  var obj = {};

  obj.get = function (q) {
    return $http.get(serviceBase + q).then(function (results) {
      return results.data;
    });
  };
  obj.post = function (q, object) {
    return $http.post(serviceBase + q, object).then(function (results) {
      return results.data;
    });
  };
  obj.put = function (q, object) {
    return $http.put(serviceBase + q, object).then(function (results) {
      return results.data;
    });
  };
  obj.delete = function (q) {
    return $http.delete(serviceBase + q).then(function (results) {
      return results.data;
    });
  };

  return obj;
}])