app.controller('enquiriesCtrl', function ($scope, $modal, $filter, Data) {
    $scope.enquiry = {};
    Data.get('enquiries').then(function(data){
        $scope.enquiries = data.data;
    });
 Data.get('divisions').then(function(data){
        $scope.classes = data.data;
      }); 
    $scope.changeenquiriestatus = function(enquiry){
        enquiry.status = (enquiry.status=="Active" ? "Inactive" : "Active");
        Data.put("enquiries/"+enquiry.id,{status:enquiry.status});
    };
    $scope.deleteenquiry = function(enquiry){
        if(confirm("Are you sure to remove the enquiry")){
            Data.delete("enquiries/"+enquiry.id).then(function(result){
                $scope.enquiries = _.without($scope.enquiries, _.findWhere($scope.enquiries, {id:enquiry.id}));
            });
        }
    };
    $scope.open = function (p,size) {
        var modalInstance = $modal.open({
          templateUrl: 'partials/adminstrator/enquiriesEdit.html',
          controller: 'enquiriesEditCtrl',
          size: size,
          resolve: {
            item: function () {
              return p;
            }
          }
        });
        modalInstance.result.then(function(selectedObject) {
            if(selectedObject.save == "insert"){
                $scope.enquiries.push(selectedObject);
                $scope.enquiries = $filter('orderBy')($scope.enquiries, 'id', 'reverse');
            }else if(selectedObject.save == "update"){
                p.id = selectedObject.id;
                p.name = selectedObject.name;
                p.gender = selectedObject.gender;
                p.number = selectedObject.number;
                p.email = selectedObject.email;
                p.class = selectedObject.class;
                p.date = selectedObject.date;
                p.followup = selectedObject.followup;
            }
        });
    };
    
 $scope.columns = [
                    {text:"ID",predicate:"id",sortable:true,dataType:"number"},
                    {text:"Name",predicate:"name",sortable:true},
                    {text:"Gender",predicate:"gender",sortable:true},
                    {text:"Phone Number",predicate:"number",sortable:true},
                    {text:"E-Mail",predicate:"email",sortable:true},
                    {text:"Class",predicate:"class",sortable:true},
                    {text:"Date",predicate:"date",sortable:true},
                    {text:"Follow Up",predicate:"followup",sortable:true},
                    {text:"Action",predicate:"",sortable:false}
                ];

});


app.controller('enquiriesEditCtrl', function ($scope, $modalInstance, item, Data) {

  $scope.enquiry = angular.copy(item);
 Data.get('divisions').then(function(data){
        $scope.classes = data.data;
      }); 
        
        $scope.cancel = function () {
            $modalInstance.dismiss('Close');
        };
        $scope.title = (item.id > 0) ? 'Edit Enquiry' : 'Add Enquiry';
        $scope.buttonText = (item.id > 0) ? 'Update Enquiry' : 'Add New Enquiry';

        var original = item;
        $scope.isClean = function() {
            return angular.equals(original, $scope.enquiry);
        }
        $scope.saveenquiry = function (enquiry) {
            console.log('1');
            // enquiry.uid = $scope.uid;
            console.log(enquiry);
            if(enquiry.id > 0){
                Data.put('enquiries/'+enquiry.id, enquiry).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(enquiry);
                        x.save = 'update';
                        $modalInstance.close(x);
                    }else{
                        console.log(result);
                    }
                });
            }else{
                Data.post('enquiry', enquiry).then(function (result) {
                    if(result.status != 'error'){
                        var x = angular.copy(enquiry);
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