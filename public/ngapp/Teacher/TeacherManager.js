'use strict';

function TeacherManager() {
    var self = this;
    var TeacherManagerClass = function ($http, $q) {
        self.$http = $http;
        self._cashPool = {};
    };
    /** METHODS */
    TeacherManagerClass.prototype = {
        //var self = this;
        /** Search Instance in the _cashPool -> looking on the server -> saves loaded Room to the _cashPool*/
        getInstance : function (object) {
            var Instance = self._cashPool(object.id);
            if (!Instance) {
                Instance = _loadInstanceById(object.id);
                if (Instance !== 400) { // add network errors status
                    self._cashPool[object.id] = Instance;
                }
            }
            return Instance;
        },
        /** Returns promise to create a room with listeners */
        createInstance : function (name) {
            return _saveInstanceByName(name);
        },
        /** Returns promise to delete a room*/
        deleteInstance : function (object) {
            return _deleteFromServerBase(object.id);
        },
        /** Returns promise to load all rooms*/
        getAllInstances : function () {
            return _loadAllInstances();
        },
        /** Returns promise to change a room*/
        changeInstance : function (object) {
            return _changeObjectRequest(object);
        },
        /** POST. Sends name to server -> Server saves adding ID -> server returns instance object with ID*/
        _saveInstanceByName : function (name) {
            self.$http.post("'api.php?controller=school_rooms&action=item&name=" + name) //wrong address
                .then(function (responce) {
                    if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                        var instance = new Teacher(responce.data);
                        self._cashPool[responce.data.id] = instance;
                        return instance;
                    }

                    $q.reject(response.status);
                }); //do we nee new then?
        },
        /**DELETE. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
        _deleteFromServerBase : function (id) {
            self.$http.delete("'api.php?controller=school_rooms&action=item&name=" + name) //wrong address
                .then(function (responce) {
                    if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                        delete self._cashPool[id];
                    }

                    $q.reject(response.status);
                }); //do we nee new then?
        },
        /** copy all instances from server to _cashPool*/
        _fillPool : function (object) {
            for (var attr in object) {
                if (object.hasOwnProperty(attr)) {
                    self._cashPool[object.id] = object[attr];
                }
            }
        },
        /**GET. Request all instance on the server -> server sends back all instances */
        _loadAllInstances : function () {
            self.$http.get("'api.php?controller=school_rooms&action=item&name=") //wrong address
                .then(function (responce) {
                    if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                        self._fillPool(responce.data);
                    }

                    $q.reject(response.status);
                }); //do we nee new then?
        },
        /** GET. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
        _loadInstanceById : function (id) {
            self.$http.get("'api.php?controller=school_rooms&action=item&id=" + id) //wrong address
                .then(function (responce) {
                    if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                        var instance = new Teacher(responce.data);
                        self._cashPool[responce.data.id] = instance;
                        return instance;
                    }

                    $q.reject(response.status);
                }); //do we nee new then?
        },
        /**POST. Sends object to server -> Server looks for instance with this ID -> server changes object in DB -> server sends back the object*/
        _changeObjectRequest : function (object) {
            self.$http.post("'api.php?controller=school_rooms&action=item&id=" + object.id, JSON.stringify(object))//wrong address, correct JSON.stringify(object)?
                .then(function (responce) {
                    if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                        self._cashPool[responce.data.id] = responce.data;
                    }

                    $q.reject(response.status);
                }); //do we nee new then?
        }
    };

    return TeacherManagerClass;
}
