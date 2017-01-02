
 var app = angular.module('service', []);

 	app.factory('personSrv',function ($resource){
         return $resource('../backend/index.php/person/:id', {id: '@id'}, {
            'update': {method: 'PUT'}
        });
    });

    app.factory('personSrv1',function ($http)
    {
     	 var updateUrl = '../backend/index.php/person/update/:id';    
     	 var deleteUrl = '../backend/index.php/person/delete/:id';    


     	 return {
     	 	updateUser: function(info){
     	 		return $http.post(updateUrl,{"id":info.id, "name":info.name,"address":info.address, "hobbies":info.hobbies}).success(function(data){
     	 			return data;
     	 		});
     	 	},
     	 	deleteUser: function(id){
     	 		return $http.post(deleteUrl,{"id":id}).success(function(data){
     	 			return data;
     	 		});
     	 	}
     	 }

	});
     	
