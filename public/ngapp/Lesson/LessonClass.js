'use strict';

function Lesson() {
    var thisClass = this;
    var LessonClass = function (object) {
        if (object) {
            _CreateClass(object);
        }
    };

    LessonClass.prototype = {
        getID : function () {
            return thisClass.id;
        },

        getLessonDayID : function () {
            return thisClass.lessonDayID;
        },

        getLessonNumber : function () {
            return thisClass.lessonNumber;
        },

        getSchoolClassID : function () {
            return thisClass.schoolClassID;
        },

        getSubjectID : function () {
            return thisClass.subjectID;
        },

        getSchoolRoomID : function () {
            return thisClass.schoolRoomID;
        },

        getTeacherID : function () {
            return thisClass.teacherID;
        },

        setID : function (newId) {
            thisClass.id = parseInt(newId, 10);
        },

        setLessonDayID: function (newId) {
            thisClass.lessonDayID = parseInt(newId, 10);
        },

        setLessonNumber: function (newId) {
            thisClass.lessonNumber = parseInt(newId, 10);
        },

        setSchoolClassID: function (newId) {
            thisClass.schoolClassID = parseInt(newId, 10);
        },

        setSubjectID: function (newId) {
            thisClass.subjectID = parseInt(newId, 10);
        },

        setSchoolRoomID: function (newId) {
            thisClass.schoolRoomID = parseInt(newId, 10);
        },

        setTeacherID: function (newId) {
            thisClass.teacherID = parseInt(newId, 10);
        },

        _CreateClass : function (object) {
            thisClass.id = parseInt(object.id, 10);
            thisClass.lessonDayID = parseInt(object.lessonDayID, 10);
            thisClass.lessonNumber = parseInt(object.lessonNumber, 10);
            thisClass.schoolClassID = parseInt(object.schoolClassID, 10);
            thisClass.subjectID = parseInt(object.subjectID, 10);
            thisClass.schoolRoomID = parseInt(object.schoolRoomID, 10);
            thisClass.teacherID = parseInt(object.teacherID, 10);
        }
    };

    return LessonClass;
}