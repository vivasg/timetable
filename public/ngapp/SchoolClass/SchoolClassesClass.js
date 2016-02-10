'use strict';

function SchoolClass() {
    var thisClass = this;
    var SchoolClassesClass = function (object) {
        if (object) {
            _CreateClass(object.id, object.name);
        }
    };

    SchoolClassesClass.prototype = {
        getID : function () {
            return thisClass.id;
        },
        //angular.extend(dst, src);
        setID : function (newId) {
            if (_validateID(newId)) {
                //angular.extend(thisClass.id, parseInt(newId, 10));
                thisClass.id = parseInt(newId, 10);
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " ID not valid", newId);
            }
        },

        getName : function () {
            return this.name;
        },

        setName : function (newName) {
            if (_validateName(newName)) {
                thisClass.name = newName;
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " name not valid", newName);
            }
        },

        _validateID : function (newId) {
            return (isFinite(newId));
        },

        _validateName : function (newName) {
            return (newName !== "" && newName.length <= 255 && newName.length >= 3);
        },

        _CreateClass : function (newId, newName) {
            if (_validateID(newId)) {
                thisClass.id = parseInt(newId, 10);
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " ID not valid", newId);
                return;
            }

            if (_validateName(newName)) {
                thisClass.name = newName;
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " name not valid", newName);
            }
        }
    };

    return SchoolClassesClass;
}

angular
    .module('app', ['$http', '$q']) // dependency?
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





























