app.controller('classesCtrl', function ($scope, $modal, $filter, Data) {
    $scope.division = {};
    Data.get('divisions').then(function(data){
        $scope.divisions = data.data;
    });
    $scope.changedivisionstatus = function(division){
        division.status = (division.status=="Active" ? "Inactive" : "Active");
        Data.put("divisions/"+division.id,{status:division.status});
    };
    $scope.deletedivision = function(division){
        if(confirm("Are you sure to remove the division")){
            Data.delete("divisions/"+division.id).then(function(result){
                $scope.divisions = _.without($scope.divisions, _.findWhere($scope.divisions, {id:division.id}));
            });
        }
    };
    $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/classesEdit.html',
          controller: 'classesEditCtrl',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });
        modalInstance.result.then(function(selectedObject) {
            if(selectedObject.save == "insert"){
                $scope.divisions.push(selectedObject);
                $scope.divisions = $filter('orderBy')($scope.divisions, 'id', 'reverse');
            }else if(selectedObject.save == "update"){
                p.name = selectedObject.name;
            }
        });
    };
    
 $scope.columns = [
                    {text:"ID",predicate:"id",sortable:true,dataType:"number"},
                    {text:"Name",predicate:"name",sortable:true}
                ];

});


app.controller('classesEditCtrl', function ($scope, $modalInstance, item, Data) {

  $scope.division = angular.copy(item);
        
        $scope.cancel = function () {
            $modalInstance.dismiss('Close');
        };
        // $scope.title = (item.id > 0) ? 'Edit Class' : 'Add Class';
        // $scope.buttonText = (item.id > 0) ? 'Update Class' : 'Add New Class';

        var original = item;
        $scope.isClean = function() {
            return angular.equals(original, $scope.division);
        }
        $scope.savedivision = function (division) {
            console.log('1');
            // division.uid = $scope.uid;
            console.log(division);
            if(division.id > 0){
                Data.put('divisions/'+division.id, division).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(division);
                        x.save = 'update';
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }else{
                Data.post('divisions', division).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(division);
                        x.save = 'insert';
                        x.id = result.data;
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }
        };
});
