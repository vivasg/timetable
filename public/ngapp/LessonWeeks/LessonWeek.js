'use strict';

function LessonWeek() {
    var thisClass = this;
    var LessonWeekClass = function (object) {
        if (object) {
            _CreateClass(object.id, object.number, object.name);
        }
    };

    LessonWeekClass.prototype = {
        getID : function () {
            return thisClass.id;
        },

        getNumber : function () {
            return thisClass.number;
        },

        getName : function () {
            return thisClass.name;
        },

        setID : function (newId) {
            if (_validateID(newId)) {
                thisClass.id = parseInt(newId, 10);
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " ID not valid", newId);
            }
        },

        setNumber : function (newNumber) {
            if (_validateNumber(newNumber)) {
                thisClass.id = parseInt(newNumber, 10);
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " week number not valid", newNumber);
            }
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

        _validateNumber : function (newNumber) {
            return (isFinite(newNumber) && newNumber >= 0 && newNumber < 4);
        },
        _validateName : function (newName) {
            return (newName !== "" && newName.length <= 255 && newName.length >= 3);
        },

        _CreateClass : function (newId, newNumber, newName) {
            if (_validateID(newId)) {
                thisClass.id = parseInt(newId, 10);
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " ID not valid", newId);
                return;
            }

            if (_validateNumber(newNumber)) {
                thisClass.id = parseInt(newNumber, 10);
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " week number not valid", newNumber);
                return;
            }

            if (_validateName(newName)) {
                thisClass.name = newName;
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " name not valid", newName);
            }
        }
    };

    return LessonWeekClass;
}
