	/*
	app.controller('teacherCtrl', ['$scope', '$http',
		function ($scope, $http) {
			$http.get('api/teachers').success(function(responce) {
				$scope.teachers = responce.data;
			});
		}
	]);
  	*/

	app.controller('teacherCtrl', ['$scope', 'getter',
		function ($scope, getter) {
			getter.all('teachers').success(function(responce) {
				$scope.teachers = responce.data;
			});
		}
	]);

	app.controller('subjectCtrl', ['$scope', 'getter',
		function ($scope, getter) {
			getter.all('subjects').success(function(responce) {
				$scope.subjects = responce.data;
			});
		}
	]);
	
	app.controller('lessonDayCtrl', ['$scope', 'getter',
		function ($scope, getter) {
			getter.all('lessonDays').success(function(responce) {
				$scope.lessonDays = responce.data;
			});
		}
	]);
	
	app.controller('lessonDayShowCtrl', ['$scope', '$http', '$routeParams',
		function ($scope, $http, $routeParams) {
			$http.get('api/lessonDays/' + $routeParams.id)
			.success(function(responce) {	
				$scope.day = responce.data.attributes;
			});
		}
	]);

	app.controller('teacherShowCtrl', ['$scope', '$http', '$routeParams',
		function ($scope, $http, $routeParams) {
			$scope.deleteTeacher = function() {
				$http.delete('api/teachers/' + $routeParams.id);
			};
			
			$http.get('api/teachers/' + $routeParams.id)
			.success(function(responce) {
				$scope.teacher = responce.data.attributes;
			})
			.catch(function(error){
				alert(1);
			});
		}
	]);
  
	app.controller('teacherAddCtrl', ['$scope', '$http',
		function ($scope, $http) {
			$scope.saveTeacher = function(teacher) {
				$http.put('api/teachers/',  JSON.stringify(teacher));
			};
		}
	]);
  
	app.controller('subjectShowCtrl', ['$scope', '$http', '$routeParams',
		function ($scope, $http, $routeParams) {
			$http.get('api/subjects/' + $routeParams.id).success(function(responce) {
				$scope.subject = responce.data.attributes;
			});
		}
	]);
	
	
	
	
	
	