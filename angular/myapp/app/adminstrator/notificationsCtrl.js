app.controller('notificationsCtrl', function($scope, $modal, $filter, Data) {
    $scope.notification = {};

    Data.get('notifications').then(function(data) {
        $scope.notifications = data.data;
        console.log("data.data");
        console.log(data.data);
    });
    $scope.do = function() {
        Data.getbatch('studentsBatch', $scope.class, $scope.batch, $scope.subject).then(function(data) {
            $scope.notifications = data.data;
        });
    };
    $scope.changeStudentstatus = function(student) {
        student.status = (student.status == "Active" ? "Inactive" : "Active");
        Data.put("students/" + student.id, { status: student.status });
    };
    $scope.deleteFtudent = function(student) {
        if (confirm("Are you sure to remove the student")) {
            Data.delete("students/" + student.id).then(function(result) {
                $scope.notifications = _.without($scope.notifications, _.findWhere($scope.notifications, { id: student.id }));
            });
        }
    };
    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/adminstrator/notificationsEdit.html',
            controller: 'notificationEditCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });
        modalInstance.result.then(function(selectedObject) {
            if (selectedObject.save == "insert") {
                $scope.notifications.push(selectedObject);
                $scope.notifications = $filter('orderBy')($scope.notifications, 'id', 'reverse');
            } else if (selectedObject.save == "update") {
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
        { text: "ID", predicate: "id", sortable: true, dataType: "number" },
        { text: "title", predicate: "title", sortable: true },
        { text: "message", predicate: "message", sortable: true },
        { text: "class", predicate: "class", sortable: true },
        { text: "batch", predicate: "batch", sortable: true },
        { text: "date", predicate: "date", sortable: true }
    ];

});

app.controller('notificationEditCtrl', function($scope, Upload, $timeout, $modalInstance, item, Data) {

    $scope.notification = angular.copy(item);

    $scope.cancel = function() {
        $modalInstance.dismiss('Close');
    };
    // $scope.title = (item.id > 0) ? 'Edit student' : 'Add student';
    // $scope.buttonText = (item.id > 0) ? 'Update student' : 'Add New student';

    var original = item;
    $scope.isClean = function() {
        return angular.equals(original, $scope.notification);
    }
    $scope.savenotification = function(notification) {
        console.log(notification);
        if (notification.id > 0) {
            Data.put('notifications/' + notification.id, notification).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(notification);
                    x.save = 'update';
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        }
        else {
            Data.post('notification', notification).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(notification);
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





