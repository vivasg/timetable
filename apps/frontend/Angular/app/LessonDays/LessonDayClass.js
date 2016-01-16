'use strict';

function LessonDay(object) {
    var thisClass = this;
    if (object) {
        _CreateClass(object.id, object.lessonWeekID, object.wDay, object.name, object.lessonMaxCount);
    }

    LessonDay.prototype = {
        getID : function () {
            return thisClass.id;
        },

        getLessonWeekID : function () {
            return thisClass.lessonWeekID;
        },

        getWday : function () {
            return thisClass.wDay;
        },

        getName : function () {
            return thisClass.name;
        },

        getlessonMaxCount : function () {
            return thisClass.lessonMaxCount;
        },

        setID : function (newId) {
            thisClass.id = parseInt(newId, 10);
        },

        setLessonWeekID : function (newLessonWeekID) {
            thisClass.lessonWeekID = parseInt(newLessonWeekID, 10);
        },

        setWday : function (newWday) {
            thisClass.wDay = parseInt(newWday, 10);
        },

        setName : function (newName) {
            thisClass.name = newName;
        },

        setLessonMaxCount : function (newLessonMaxCount) {
            thisClass.lessonMaxCount = parseInt(newLessonMaxCount, 10);
        },

        _CreateClass : function (newId, newLessonWeekID, newWday, newName, newLessonMaxCount) {
            thisClass.id = parseInt(newId, 10);
            thisClass.lessonWeekID = parseInt(newLessonWeekID, 10);
            thisClass.wDay = parseInt(newWday, 10);
            thisClass.name = newName;
            thisClass.lessonMaxCount = parseInt(newLessonMaxCount, 10);
        }
    };

    return thisClass;
}

angular
    .factory('LessonDay', LessonDay);