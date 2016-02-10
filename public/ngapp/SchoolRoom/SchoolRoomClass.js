'use strict';

function SchoolRoom() {
    var thisClass = this;
    var SchoolRoomClass = function (object) {
        if (object) {
            _CreateClass(object.id, object.name);
        }
    };

    SchoolRoomClass.prototype = {
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

    return SchoolRoomClass;
}
