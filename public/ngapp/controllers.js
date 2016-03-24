app.controller('teacherCtrl', ['$scope', '$http',
  function ($scope, $http) {
	$http.get('api/teachers').success(function(responce) {
		$scope.teachers = responce.data;
    });
  }]);
  
 app.controller('subjectCtrl', ['$scope', '$http',
  function ($scope, $http) {
    $http.get('api/subjects').success(function(responce) {
		$scope.subjects = responce.data;
    });
  }]);
  
  app.controller('teacherShowCtrl', ['$scope', '$http', '$routeParams',
  function ($scope, $http, $routeParams) {
    $http.get('api/teachers/' + $routeParams.id).success(function(responce) {
		$scope.teacher = responce.data.attributes;
    });
  }]);
  
  app.controller('subjectShowCtrl', ['$scope', '$http', '$routeParams',
  function ($scope, $http, $routeParams) {
    $http.get('api/subjects/' + $routeParams.id).success(function(responce) {
		$scope.subject = responce.data.attributes;
    });
  }]);