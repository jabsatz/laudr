(function(){

  var app = angular.module('laudr', []);

  app.controller('DashController', ['$http', function($http){
    var dash = this;
    dash.data = [];

    $http.get('/laud').success(function(data){
      dash.data = data;
    });
  }])
  
})();