function LessonClass() {
	var Lesson = function (newName, newTeacher) {
		this.lessonName = newName;
		this.Teacher = newTeacher;
	};
	return Lesson;
}
/*****************************************************/
function DayClass() {
	//var self = this;
	var lessonDay = function (newName) {
		this.name = newName;
		this.lessonArray = [];
	};

	lessonDay.prototype = {
		addLesson : function (newLesson, index) {
			//this.lessonArray.push(newLesson);
			this.lessonArray.splice(index, 1, newLesson);
		},

		fillAll : function () {
			for (var i = 0; i < 8; i++) {
				this.lessonArray[i] = {};
			}
		},

		removeLesson : function (number) {
			this.lessonArray.splice(number, 1);
		},

		printAllLessons : function () {
			for (var i = 0; i < this.lessonArray.length; i++){
				console.log(this.lessonArray[i].lessonName);
			}
		}
	};

	return lessonDay;
}
/*****************************************************/

function schoolForm() {
	var Form = function (newName) {
		this.name = newName;
		this.daysArray = [];
		this.unusedLessons = [];
	};

	Form.prototype = {
		addDay : function (newDay) {
			this.daysArray.push(newDay);
			//this.daysArray.splice(index, 0, newDay);
		},

		addUnresolved : function (newLesson) {
			this.unusedLessons.push(newLesson);
		}

	};

	return Form;
}
/*****************************************************/



function SideBarsController($scope){
	$scope.daysArr = ["Monday", "Tuesday", "Wednesday"];
	$scope.daysNumberArr = ["0", "1", "2", "3", "4", "5", "6", "7"];
	$scope.classesSidebarArr = ["6 - a", "6 - б", "7 - a", "8 - a", "9 - a", "11 - a", "12 - a"];
}

function SimpleDemoController($scope, LessonClass, DayClass, schoolForm, LessonWeekManager){
	var lMonOne = new LessonClass("1.1", "Abrams");
	var lMonTwo = new LessonClass("1.2", "Lester");
	var Monday = new DayClass("Monday");

	Monday.fillAll();
	Monday.addLesson(lMonOne, 0);
	Monday.addLesson(lMonTwo, 2);

	var lTueOne = new LessonClass("2.1", "Abrams");
	var lTueTwo = new LessonClass("2.2", "Lester");
	var Tuesday = new DayClass("Tuesday");

	Tuesday.fillAll();
	Tuesday.addLesson(lTueOne, 0);
	Tuesday.addLesson(lTueTwo, 3);

	var Form = new schoolForm("7 - B");

	Form.addDay(Monday, 0);
	Form.addDay(Tuesday, 1);

	var UnresOne = new LessonClass("Music", "H");
	var UnresTwo = new LessonClass("Singing", "S");
	var UnresThree = new LessonClass("PE", "G");
	var UnresFour = new LessonClass("PE", "G");
	var UnresFive = new LessonClass("PE", "G");

	Form.addUnresolved(UnresOne);
	Form.addUnresolved(UnresTwo);
	Form.addUnresolved(UnresThree);
	Form.addUnresolved(UnresFour);
	Form.addUnresolved(UnresFive);

	$scope.models = {
		selected: null,
		lists: {
			"A": {},
			"B": {},
			"unresolved" : {}
		}
	};

	function FillLessonView (LessonArray, Day) {
		for (i in LessonArray)
		{
			if(Object.keys(LessonArray[i]).length == 0) {
				Day[i] = [];
			} else {
				Day[i] = [LessonArray[i]];
			}
		}
	}

	FillLessonView(Form.daysArray[0].lessonArray, $scope.models.lists.A);
	FillLessonView(Form.daysArray[1].lessonArray, $scope.models.lists.B);
	FillLessonView(Form.unusedLessons, $scope.models.lists.unresolved);

	/** for file save*/
	$scope.dropCallback = function(event, index, item, external, type, allowedType) {
		if (external) {
			if (allowedType === 'itemType' && !item.lessonName) return false;
			if (allowedType === 'containerType' && !angular.isArray(item)) return false;
		}

		return item;
	};

	var lessonWeekManager = new LessonWeekManager();
	lessonWeekManager.getAllInstances().then(function(data)
	{
		"use strict";
		console.log(data);
	});
}

angular
	.module('app', ["dndLists"])
	.factory('LessonClass', LessonClass)
	.factory('DayClass', DayClass)
	.factory('schoolForm', schoolForm)
	.controller('SideBarsController', SideBarsController)
	.controller('SimpleDemoController', SimpleDemoController, ['LessonClass', 'DayClass', 'schoolForm', 'LessonWeekManager'])

	.factory('SchoolClass', SchoolClass)
	.factory('SchoolRoom', SchoolRoom)
	.factory('Subject', Subject)
	.factory('LessonWeek', LessonWeek)
	.factory('LessonDay', LessonDay, ['LessonWeek'])
	.factory('Teacher', Teacher)
	.factory('Lesson', Lesson, ['SchoolClass', 'SchoolRoom', 'Subject', 'LessonDay', 'LessonWeek', 'Teacher'])

	.factory('TeacherManager', TeacherManager, ['Teacher', '$http', '$q'])
	.factory('SubjectManager', SubjectManager, ['Subject', '$http', '$q'])
	.factory('SchoolRoomManager', SchoolRoomManager, ['SchoolRoom', '$http', '$q'])
	.factory('SchoolClassesManager', SchoolClassesManager, ['SchoolClass', '$http', '$q'])
	.factory('LessonWeekManager', LessonWeekManager, ['LessonWeek', '$http', '$q'])
	.factory('LessonDayManager', LessonDayManager, ['LessonDay', '$http', '$q'])
	.factory('LessonManager', LessonManager, ['Lesson', '$http', '$q']);




