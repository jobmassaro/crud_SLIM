(function () {
    var app = angular.module('service', []);
    app.factory('personSrv',function ($resource){
         return $resource('../backend/index.php/person/:id', {id: '@id'}, {
            'update': {method: 'PUT'}
        });
    });
})();