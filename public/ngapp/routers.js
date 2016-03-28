app.config(['$routeProvider', '$locationProvider',
	function($routeProvider, $locationProvider) {
		$routeProvider.
			when('/teachers', {
				templateUrl: 'template/pages/teachers/index.html',
				controller: 'teacherCtrl'
			}).
			when('/subjects', {
				templateUrl: 'template/pages/subjects/index.html',
				controller: 'subjectCtrl'
			}).
			when('/lessonDays', {
				templateUrl: 'template/pages/lessonDays/index.html',
				controller: 'lessonDayCtrl'
			}).
			when('/lessonDays/:id', {
				templateUrl: 'template/pages/LessonDay/index.html',
				controller: 'lessonDayShowCtrl'
			}).
			when('/teachers/:id', {
				templateUrl: 'template/pages/teacher/index.html',
				controller: 'teacherShowCtrl'
			}).
			when('/subjects/:id', {
				templateUrl: 'template/pages/subject/index.html',
				controller: 'subjectShowCtrl'
			}).
			when('/teacherAdd', {
				templateUrl: 'template/pages/add/index.html',
				controller: 'teacherAddCtrl'
			}).
			otherwise({
				redirectTo: '/'
			});
		$locationProvider.html5Mode(true);
	}
]);