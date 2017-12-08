app.controller('managersCtrl', function($scope, $modal, $filter, Data) {
    $scope.managers = {};
    Data.get('managers').then(function(data) {
        $scope.managers = data.data;
    });
    $scope.changeManagerstatus = function(managers) {
        managers.status = (managers.status == "Active" ? "Inactive" : "Active");
        Data.put("managers/" + managers.id, { status: managers.status });
    };
    $scope.deleteManager = function(managers) {
        if (confirm("Are you sure to remove the managers")) {
            Data.delete("managers/" + managers.id).then(function(result) {
                $scope.managers = _.without($scope.managers, _.findWhere($scope.managers, { id: managers.id }));
            });
        }
    };
    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/managersEdit.html',
            controller: 'managersEditCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });
        modalInstance.result.then(function(selectedObject) {
            if (selectedObject.save == "insert") {
                $scope.managers.push(selectedObject);
                $scope.managers = $filter('orderBy')($scope.managers, 'id', 'reverse');
            } else if (selectedObject.save == "update") {
                p.name = selectedObject.name;
                p.shortform = selectedObject.shortform;
            }
        });
    };

    $scope.columns = [
        { text: "ID", predicate: "id", sortable: true, dataType: "number" },
        { text: "Name", predicate: "name", sortable: true },
        { text: "Email", predicate: "email", sortable: true },
        { text: "Phone", predicate: "phone", sortable: true }
    ];
});


app.controller('managersEditCtrl', function($scope, $modalInstance, item, Data) {

    $scope.managers = angular.copy(item);

    $scope.cancel = function() {
        $modalInstance.dismiss('Close');
    };
    $scope.title = (item.id > 0) ? 'Edit Manager' : 'Add Manager';
    $scope.buttonText = (item.id > 0) ? 'Update Manager' : 'Add New Manager';

    var original = item;
    $scope.isClean = function() {
        return angular.equals(original, $scope.managers);
    }
    $scope.savemanagers = function(managers) {
        console.log('1');
        // managers.uid = $scope.uid;
        console.log(managers);
        if (managers.id > 0) {
            Data.put('managers/' + managers.id, managers).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(managers);
                    x.save = 'update';
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        } else {
            Data.post('managers', managers).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(managers);
                    x.save = 'insert';
                    x.id = result.data;
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        }
    };
});
