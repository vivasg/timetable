'use strict';

function ManagerService() {
    /** POST. Sends name to server -> Server saves adding ID -> server returns instance object with ID*/
    this.createInstanceByName = function ($http, $q, name) {
        $http.post("'api.php?controller=school_rooms&action=item&name=" + name) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { // add normal check
                    return responce; //JSON.parse(responce);
                }
                return $q.reject(response); //return response.status; // err?
            });
    };
    /**DELETE. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    this.deleteFromServerBase = function ($http, $q, id) {
        $http.delete("'api.php?controller=school_rooms&action=item&name=" + id) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { // add normal check
                    return responce; //JSON.parse(responce)
                }
                return $q.reject(response.status); //return response.status;
            }); //do we nee new then?
    };
    /**GET. Request all instance on the server -> server sends back all instances */
    this.loadAllInstances = function ($http, $q) {
        $http.get("'api.php?controller=school_rooms&action=item&name=") //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) {
                    return responce;
                }
                return $q.reject(response.status); //return response.status;
            });
    };
    /** GET. Sends ID to server -> Server looks for instance with this ID -> server returns result*/
    this.loadInstanceById = function ($http, $q, id) {
        $http.get("'api.php?controller=school_rooms&action=item&id=" + id) //wrong address
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    return responce;
                }
                return $q.reject(response.status);
            }); //do we nee new then?
    };
    /**POST. Sends object to server -> Server looks for instance with this ID -> server changes object in DB -> server sends back the object*/
    this.changeObjectRequest = function ($http, $q, object) {
        $http.post("'api.php?controller=school_rooms&action=item&id=" + object.id, JSON.stringify(object))//wrong address, correct JSON.stringify(object)?
            .then(function (responce) {
                if (responce.status >= 200 && responce.status < 300) { //JSON.parse(responce)
                    return responce.data;
                }
                return $q.reject(response.status); //return response.status;
            }); //do we nee new then?
    };
}

angular
    .module('app')
    .service('ManagerService', ManagerService);