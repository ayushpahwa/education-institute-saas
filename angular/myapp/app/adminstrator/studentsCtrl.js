app.controller('studentsCtrl', function ($scope, $modal, $filter, Data) {
    $scope.subjectSelect = {};
    console.log($scope.subjectSelect);
    $scope.student = {};

    Data.get('students').then(function(data){
        $scope.students = data.data;
    });
    console.log($scope.students);
    console.log("as");
     Data.get('subjects').then(function(data){
        $scope.subjects = data.data;
      });
 Data.get('divisions').then(function(data){
        $scope.divisions = data.data;
      }); 
  Data.get('batches').then(function(data){
        $scope.batches = data.data;
      });
    $scope.do = function(){
      Data.get('studentsBatch',$scope.class,$scope.batch,$scope.subject).then(function(data){
        $scope.students = data.data;
      });
    };
    $scope.changeStudentstatus = function(student){
        student.status = (student.status=="Active" ? "Inactive" : "Active");
        Data.put("students/"+student.id,{status:student.status});
    };
    $scope.deleteFtudent = function(student){
        if(confirm("Are you sure to remove the student")){
            Data.delete("students/"+student.id).then(function(result){
                $scope.students = _.without($scope.students, _.findWhere($scope.students, {id:student.id}));
            });
        }
    };
    $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/management/studentEdit.html',
          controller: 'studentEditCtrl',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });
        modalInstance.result.then(function(selectedObject) {
            if(selectedObject.save == "insert"){
                $scope.students.push(selectedObject);
                $scope.students = $filter('orderBy')($scope.students, 'id', 'reverse');
            }else if(selectedObject.save == "update"){
              p.id = selectedObject.id;
              p.name = selectedObject.name;
              p.batch = selectedObject.batch;
              p.father = selectedObject.father;
              p.sub5 = selectedObject.sub5;
              p.phone = selectedObject.phone;
              p.eid = selectedObject.eid;
              p.class = selectedObject.class;
              p.cn = selectedObject.cn;
              p.bn = selectedObject.bn;
              p.pic = selectedObject.pic;


            }
        });
    };

 $scope.columns = [
                    {text:"ID",predicate:"id",sortable:true,dataType:"number"},
                    {text:"Name",predicate:"name",sortable:true},
                    {text:"E-mail ID",predicate:"eid",sortable:true},
                    {text:"Phone",predicate:"phone",sortable:true,dataType:"number"},
                    {text:"Class",predicate:"class",reverse:true,sortable:true,dataType:"number"},
                    {text:"Batch",predicate:"batch",sortable:true},
                    {text:"Action",predicate:"",sortable:false}
                ];

});

app.controller('studentEditCtrl', function ($scope,Upload,$timeout, $modalInstance, item, Data) {
    $scope.subjectSelect = {};

  $scope.student = angular.copy(item);
 Data.get('subjects').then(function(data){
        $scope.subjects = data.data;
      });
 Data.get('divisions').then(function(data){
        $scope.divisions = data.data;
      }); 
  Data.get('batches').then(function(data){
        $scope.batches = data.data;
      });
  $scope.uploadPic = function(file) {
    console.log("Something is happening.");
    file.upload = Upload.upload({
      url: 'http://malhotrasdivisions.in/panel/student/img-upload.php',
      method: 'POST',
      sendFieldsAs: 'form',
      fields: {name: $scope.student.id},
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

        $scope.cancel = function () {
            $modalInstance.dismiss('Close');
        };
        $scope.title = (item.id > 0) ? 'Edit student' : 'Add student';
        $scope.buttonText = (item.id > 0) ? 'Update student' : 'Add New student';

        var original = item;
        $scope.isClean = function() {
            return angular.equals(original, $scope.student);
        }
        $scope.saveStudent = function (student) {
            console.log($scope.subjectSelect);
            student.uid = $scope.uid;
            student.sub5 ="";
            for (var i in $scope.subjectSelect) {
                  student.sub5 += $scope.subjectSelect[i] + ",";
               }
            console.log(student);
            if(student.id > 0){
                Data.put('students/'+student.id, student).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(student);
                        x.save = 'update';
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }else{
                Data.post('students', student).then(function (result) {
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

app.controller('studentFeeCtrl', function ($scope, $modalInstance, item, Data) {

  $scope.student = angular.copy(item);

  $scope.cancel = function () {
    $modalInstance.dismiss('Close');
  };

  $scope.title = (item.id > 0) ? 'Edit student' : 'Add student';
  $scope.buttonText = (item.id > 0) ? 'Update student' : 'Add New student';

  var original = item;
  $scope.isClean = function() {
    return angular.equals(original, $scope.student);
  }

  $scope.saveStudent = function (student) {
    student.uid = $scope.uid;
    console.log(student);
    if(student.id > 0){
      Data.put('students/'+student.id, student).then(function (result) {
        if(result.status != 'error'){
          var x = angular.copy(student);
          x.save = 'update';
          $modalInstance.close(x);
        }else{
          console.log(result);
        }
      });
    }else{
      Data.post('students', student).then(function (result) {
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

app.controller('enquiryCtrl', function ($scope,Data) {

  $scope.package = {};
  $scope.enquire = function(){
        Data.get('subjects').then(function(data){
           $scope.subjects = data.data;
         });
    Data.get('divisions').then(function(data){
           $scope.divisions = data.data;
         }); 
     Data.get('batches').then(function(data){
           $scope.batches = data.data;
         });
  $scope.package.name = $scope.name;
  $scope.package.gender = $scope.gender;
  $scope.package.number = $scope.phone;
  $scope.package.email =  $scope.email;
  $scope.package.class = $scope.class;
  $scope.package.sub5 = $scope.sub5;
  $scope.package.message = $scope.message;

  Data.post('enquiry',$scope.package).then(function(result){
    if(result.status != 'error'){
      alert("Inquiry Added!");
    } else {
      alert("Please try again");
    }
  });
  }
});

app.controller('viewCtrl', function ($scope,Data) {
  $scope.enquiries = {};
      Data.get('subjects').then(function(data){
         $scope.subjects = data.data;
       });
  Data.get('divisions').then(function(data){
         $scope.divisions = data.data;
       }); 
   Data.get('batches').then(function(data){
         $scope.batches = data.data;
       });
  Data.get('enquiries').then(function(data){
    $scope.enquiries = data.data;
    console.log($scope.enquiries);
  });
      $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/showfull.html',
          controller: 'showfull',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });     
    };

});




app.controller('showfull', function ($scope, $modalInstance, item, Data) {


  $scope.cancel = function () {
    $modalInstance.dismiss('Close');
  };

});

