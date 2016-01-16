'use strict';


function SchoolRoomManager($http, $q, ManagerService) {
    var thisClass = this;
    thisClass.$http = $http;
    thisClass.$q = $q;
    thisClass._cashPool = {};
    /** METHODS */
    //INTERFACE
    /** Search Instance in the _cashPool -> looking on the server -> saves loaded Room to the _cashPool*/
    thisClass.getInstance = function (object) {
        var Instance = thisClass._cashPool(object.id);
        if (!Instance) {
            Instance = this._loadInstanceById(object.id);
            if (Instance !== 400) { // add network errors status
                thisClass._cashPool[object.id] = Instance;
            }
        }
        return Instance;
    };
    /** Returns promise to create a room with listeners */
    thisClass.createInstance = function (name) {
        return _createInstanceByName(name);
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
    //PRIVATE
    /** Creates new instance -> adds it to the _cashPool -> returns instance **/
    this._createInstance = function (object) {
        var instance = new SchoolRoom(object); //TODO universal creator
        this._cashPool[object.id] = instance;
        return instance;
    };

    /** POST. Sends name to server -> Server saves adding ID -> server returns instance object with ID*/
    thisClass._createInstanceByName = function (name) {
        ManagerService.createInstanceByName(thisClass.$http, thisClass.$q, name)
            .then(function (responce) {
                thisClass._createInstance(responce.data); // JSON.parse(responce)
            }, function (responce) {
                return $q.reject(response.status);
            });
    };
    /**DELETE. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    thisClass._deleteFromServerBase = function (id) {
        ManagerService.deleteFromServerBase(thisClass.$http, thisClass.$q, id)
            .then(function (responce) {
                delete thisClass._cashPool[responce.data.id];
            }, function (responce) {
                return $q.reject(response.status);
            });
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
        ManagerService.loadAllInstances(thisClass.$http, thisClass.$q) //wrong address
            .then(function (responce) {
                thisClass._fillPool(responce.data); //responce ?
            }, function (responce) {
                return $q.reject(response.status);
            });
    };
    /** GET. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    thisClass._loadInstanceById = function (id) {
        ManagerService.loadInstanceById(thisClass.$http, thisClass.$q, id)
            .then(function (responce) {
                thisClass._createInstance(responce.data); // JSON.parse(responce)
            }, function (responce) {
                return $q.reject(response.status);
            });
    };
    /**POST. Sends object to server -> Server looks for instance with this ID -> server changes object in DB -> server sends back the object*/
    thisClass._changeObjectRequest = function (object) {
        ManagerService.changeObjectRequest(thisClass.$http, thisClass.$q, object)//wrong address, correct JSON.stringify(object)?
            .then(function (responce) {
                thisClass._cashPool[responce.data.id] = responce.data; // JSON.parse(responce)
            }, function (responce) {
                return $q.reject(response.status);
            });
    };

    return thisClass;
}

angular
    .module('app', ['$http', '$q', 'ManagerService'])
    .factory('SchoolRoomManager', SchoolRoomManager);