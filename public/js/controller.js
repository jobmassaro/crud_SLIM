(function () {
    var person = {};
    var app = angular.module('controller', []);
    app.controller('personCtrl', function ($scope, $state, personSrv,personSrv1){

        function getAll() {
            $scope.datas = personSrv.query();
        };
        getAll();
        $scope.add = function () {
            person = {};
            $state.go('form');
        };

        $scope.edit = function (data) {
            person = data;
            $state.go('edit');
            
        };

        $scope.remove = function (data)
        {
            var r = confirm("Are you sure delete this person ? ");
            if (r === true) {

               personSrv1.deleteUser(data.id).success(function(data){
                    getAll();
                    alert('Delete Data Success');
                });
            } else {
                getAll();
            }
        };
    });
    app.controller('formCtrl', function ($scope, $state, personSrv, personSrv1) {
        $scope.post = person;

        $scope.back = function () {
            $state.go('person');
        };
        $scope.save = function (data) {
            
                console.log("data =>:" + data.name);
            if ($scope.post.id === undefined) {

                 personSrv1.updateUser(data).success(function(data){
                    alert('Save Data Success');
                    $state.go('person');    
                    return data;
                 });
            } else {

                 personSrv1.updateUser(data).success(function(data){
                   alert('Update Data Success');
                   $state.go('person');    
                 });

            }
        };
    });
})();