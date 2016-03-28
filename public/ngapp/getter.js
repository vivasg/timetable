app.factory("getter", ['$http',
    function GetterFactory($http) {
        return {
            all: function(arg) {
                return $http.get('api/' + arg);
            }
        }
    }
]);