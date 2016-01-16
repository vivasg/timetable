'use strict';

function Techer(object) {
    var thisClass = this;
    if (object) {
        _CreateClass(object.newId, object.newName, object.newMidName, object.newLastName);
    }

    Teacher.prototype = {
        getID: function () {
            return thisClass.id;
        },

        getName: function () {
            return thisClass.name;
        },

        getMidName: function () {
            return thisClass.midName;
        },

        getLastName: function () {
            return thisClass.lastName;
        },

        setID: function (newId) {
            if (_validateID(newId)) {
                this.id = parseInt(newId, 10);
            } else {
                logMyErrors("Setter " + this.constructor.name + " ID not valid", newId);
            }
        },

        setName: function (newName) {
            if (_validateName(newName)) {
                thisClass.name = newName;
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " name not valid", newName);
            }
        },

        setMidName: function (newMidName) {
            if (_validateName(newMidName)) {
                thisClass.midName = newMidName;
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " MidName not valid", newMidName);
            }
        },

        setLastName: function (newLastName) {
            if (_validateName(newLastName)) {
                thisClass.lastName = newLastName;
            } else {
                logMyErrors("Setter " + thisClass.constructor.name + " LastName not valid", newLastName);
            }
        },

        _validateID: function (newId) {
            return (isFinite(newId));
        },

        _validateName: function (newName) {
            return (newName !== "" && newName.length <= 255 && newName.length >= 3);
        },

        _CreateClass: function (newId, newName, newMidName, newLastName) {
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

            if (_validateName(newMidName)) {
                thisClass.midName = newMidName;
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " MidName not valid", newMidName);
            }

            if (_validateName(newLastName)) {
                thisClass.LastName = newLastName;
            } else {
                logMyErrors("Constructor - " + thisClass.constructor.name + " LastName not valid", newLastName);
            }
        }
    };

    return thisClass;
}

angular
    .factory('SchoolClass', Techer);