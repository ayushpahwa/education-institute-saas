app.controller('batchesCtrl', function ($scope, $modal, $filter, Data) {
    $scope.batch = {};
    Data.get('batches').then(function(data){
        $scope.batches = data.data;
    });
    $scope.deleteStudent = function(batch){
        if(confirm("Are you sure to remove the batch")){
            Data.delete("batches/"+batch.id).then(function(result){
                $scope.batches = _.without($scope.batches, _.findWhere($scope.batches, {id:batch.id}));
            });
        }
    };
    $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/management/batchesEdit.html',
          controller: 'batchesEditCtrl',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });
        modalInstance.result.then(function(selectedObject) {
            if(selectedObject.save == "insert"){
                $scope.batches.push(selectedObject);
                $scope.batches = $filter('orderBy')($scope.batchs, 'id', 'reverse');
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


app.controller('batchesEditCtrl', function ($scope, $modalInstance, item, Data) {

  $scope.batch = angular.copy(item);
        
        $scope.cancel = function () {
            $modalInstance.dismiss('Close');
        };
        // $scope.title = (item.id > 0) ? 'Edit Batch' : 'Add Batch';
        // $scope.buttonText = (item.id > 0) ? 'Update Batch' : 'Add New Batch';

        var original = item;
        $scope.isClean = function() {
            return angular.equals(original, $scope.batch);
        }
        $scope.savebatch = function(batch) {
            console.log('1');
            // batch.uid = $scope.uid;
            console.log($scope.batch);
            if(batch.id > 0){
                Data.put('batches/'+batch.id, batch).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(batch);
                        x.save = 'update';
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }else{
                Data.post('batches', batch).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(student);
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
