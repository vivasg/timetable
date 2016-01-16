'use strict';


function SubjectManager($http, $q) {
    var thisClass = this;
    thisClass.$http = $http;
    thisClass._cashPool = {};
    /** METHODS */
    /** Search Instance in the _cashPool -> looking on the server -> saves loaded Room to the _cashPool*/
    thisClass.getInstance = function (object) {
        var Instance = thisClass._cashPool(object.id);
        if (!Instance) {
            Instance = _loadInstanceById(object.id);
            if (Instance !== 400) { // add network errors status
                thisClass._cashPool[object.id] = Instance;
            }
        }
        return Instance;
    };
    /** Returns promise to create a room with listeners */
    thisClass.createInstance = function (name) {
        return _saveInstanceByName(name);
    };
    /** Returns promise to delete a room*/
    thisClass.deleteInstance = function (object) {
        return _deleteFromServerBase(object.id);
    };
    /** Returns promise to load all rooms*/
    thisClass.getAllInstances = function () {
        return _loadAllInstances();
    };
    /** Returns promise to change a room*/
    thisClass.changeInstance = function (object) {
        return _changeObjectRequest(object);
    };

    /** POST. Sends name to server -> Server saves adding ID -> server returns instance object with ID*/
    thisClass._saveInstanceByName = function (name) {
        thisClass.$http.post("'api.php?controller=school_rooms&action=item&name=" + name) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    var instance = new SubjectClass(responce.data);
                    thisClass._cashPool[responce.data.id] = instance;
                    return instance;
                }

                return response.status; //$q.reject(response.status) ??
            }); //do we nee new then?
    };
    /**DELETE. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    thisClass._deleteFromServerBase = function (id) {
        thisClass.$http.delete("'api.php?controller=school_rooms&action=item&name=" + name) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    delete thisClass._cashPool[id];
                }

                return response.status; //$q.reject(response.status) ??
            }); //do we nee new then?
    };
    /** copy all instances from server to _cashPool*/
    thisClass._fillPool = function (object) {
        for (var attr in object) {
            if (object.hasOwnProperty(attr)) {
                thisClass._cashPool[object.id] = object[attr];
            }
        }
    };
    /**GET. Request all instance on the server -> server sends back all instances */
    thisClass._loadAllInstances = function () {
        thisClass.$http.get("'api.php?controller=school_rooms&action=item&name=") //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    thisClass._fillPool(responce.data);
                }

                return response.status; //$q.reject(response.status) ??
            }); //do we nee new then?
    };
    /** GET. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    thisClass._loadInstanceById = function (id) {
        thisClass.$http.get("'api.php?controller=school_rooms&action=item&id=" + id) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    var instance = new SubjectClass(responce.data);
                    thisClass._cashPool[responce.data.id] = instance;
                    return instance;
                }

                return response.status; //$q.reject(response.status) ??
            }); //do we nee new then?
    };
    /**POST. Sends object to server -> Server looks for instance with this ID -> server changes object in DB -> server sends back the object*/
    thisClass._changeObjectRequest = function (object) {
        thisClass.$http.post("'api.php?controller=school_rooms&action=item&id=" + object.id, JSON.stringify(object))//wrong address, correct JSON.stringify(object)?
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    thisClass._cashPool[responce.data.id] = responce.data;
                }

                return response.status; //$q.reject(response.status) ??
            }); //do we nee new then?
    };

    return thisClass;
}

angular
    .module('app', ['$http', '$q'])
    .factory('SubjectManager', SubjectManager);