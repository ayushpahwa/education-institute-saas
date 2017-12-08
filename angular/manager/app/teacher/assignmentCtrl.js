app.controller('assignmentCtrl', function ($scope,Upload,$timeout, $modal, $filter, Data) {
    $scope.assignment = {};
    Data.get('portalAS/').then(function(data){
        $scope.assignment = data.data;
    });
    $scope.changeassignmentstatus = function(assignment){
        assignment.status = (assignment.status=="Active" ? "Inactive" : "Active");
        Data.put("assignments/"+assignment.id,{status:assignment.status});
    };
    $scope.deleteFtudent = function(assignment){
        if(confirm("Are you sure to remove the assignment")){
            Data.delete("assignments/"+assignment.id).then(function(result){
                $scope.assignment = _.without($scope.assignment, _.findWhere($scope.assignment, {id:assignment.id}));
            });
        }
    };
      $scope.uploadPic = function(file,id) {
      
    console.log("Something is happening.");
    console.log(id);
    file.upload = Upload.upload({
      url: 'http://malhotrasclasses.in/panel/assignments/img-upload.php',
      method: 'POST',
      sendFieldsAs: 'form',
      fields: {name: id},
      file: file
    });

    file.upload.then(function (response) {
      $timeout(function () {
        file.result = response.data;
      });
    }, function (response) {
      if (response.status > 0)
        $scope.errorMsg = response.status + ': ' + response.data;
      });

      file.upload.progress(function (evt) {
        // Math.min is to fix IE which reports 200% sometimes
        file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
      });
    };

    $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/teacher/assignmentEdit.html',
          controller: 'assignmentEditCtrl',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });
        modalInstance.result.then(function(selectedObject) {
            if(selectedObject.save == "insert"){
                $scope.assignment.push(selectedObject);
                $scope.assignment = $filter('orderBy')($scope.assignment, 'id', 'reverse');
            }else if(selectedObject.save == "update"){
                p.phone = selectedObject.phone;
                p.eid = selectedObject.eid;
                p.fn = selectedObject.fn;
                p.mn = selectedObject.mn;
                p.class = selectedObject.class;
                p.cn = selectedObject.cn;
                p.bn = selectedObject.bn;
            }
        });
    };
    
 $scope.columns = [
                    {text:"ID",predicate:"id",sortable:true,dataType:"number"},
                    {text:"Name",predicate:"name",sortable:true},
                    {text:"Class",predicate:"eid",sortable:true},
                    {text:"HASH",predicate:"batch",sortable:true},
                    {text:"Action",predicate:"",sortable:false}
                ];

});


app.controller('assignmentEditCtrl', function ($scope, $modalInstance, item, Data) {

  $scope.assignment = angular.copy(item);
        Data.get('divisions').then(function(data){
        $scope.divisions = data.data;
    });
        $scope.cancel = function () {
            $modalInstance.dismiss('Close');
        };
        $scope.title = (item.id > 0) ? 'Edit Assignment' : 'Add Assignment';
        $scope.buttonText = (item.id > 0) ? 'Update Assignment' : 'Add New Assignment';

        var original = item;
        $scope.isClean = function() {
            return angular.equals(original, $scope.assignment);
        }
        $scope.saveassignment = function (assignment) {
            console.log('1');
            assignment.uid = $scope.uid;
            console.log(assignment);
            if(assignment.id > 0){
                Data.put('assignments/'+assignment.id, assignment).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(assignment);
                        x.save = 'update';
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }else{
                Data.post('assignments', assignment).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(assignment);
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

