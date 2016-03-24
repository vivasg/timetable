app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/teachers', {
        templateUrl: 'template/pages/teachers/index.html',
        controller: 'teacherCtrl'
      }).
      when('/subjects', {
        templateUrl: 'template/pages/subjects/index.html',
        controller: 'subjectCtrl'
      }).
	  when('/teachers/:id', {
        templateUrl: 'template/pages/teacher/index.html',
        controller: 'teacherShowCtrl'
      }).
	  when('/subjects/:id', {
        templateUrl: 'template/pages/subject/index.html',
        controller: 'subjectShowCtrl'
      }).
      otherwise({
        redirectTo: '/'
      });
  }]);