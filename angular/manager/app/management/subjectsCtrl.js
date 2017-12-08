app.controller('subjectsCtrl', function($scope, $modal, $filter, Data) {
    $scope.subject = {};
    Data.get('subjects').then(function(data) {
        $scope.subjects = data.data;
    });
    $scope.changeSubjectstatus = function(subject) {
        subject.status = (subject.status == "Active" ? "Inactive" : "Active");
        Data.put("subjects/" + subject.id, { status: subject.status });
    };
    $scope.deleteSubject = function(subject) {
        if (confirm("Are you sure to remove the subject")) {
            Data.delete("subjects/" + subject.id).then(function(result) {
                $scope.subjects = _.without($scope.subjects, _.findWhere($scope.subjects, { id: subject.id }));
            });
        }
    };
    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/management/subjectsEdit.html',
            controller: 'subjectsEditCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });
        modalInstance.result.then(function(selectedObject) {
            if (selectedObject.save == "insert") {
                $scope.subjects.push(selectedObject);
                $scope.subjects = $filter('orderBy')($scope.subjects, 'id', 'reverse');
            } else if (selectedObject.save == "update") {
                p.name = selectedObject.name;
                p.shortform = selectedObject.shortform;
            }
        });
    };

    $scope.columns = [
        { text: "ID", predicate: "id", sortable: true, dataType: "number" },
        { text: "Name", predicate: "name", sortable: true },
        { text: "Shortcode", predicate: "eid", sortable: true }
    ];

});


app.controller('subjectsEditCtrl', function($scope, $modalInstance, item, Data) {

    $scope.subject = angular.copy(item);

    $scope.cancel = function() {
        $modalInstance.dismiss('Close');
    };
    $scope.title = (item.id > 0) ? 'Edit Subject' : 'Add Subject';
    $scope.buttonText = (item.id > 0) ? 'Update Subject' : 'Add New Subject';

    var original = item;
    $scope.isClean = function() {
        return angular.equals(original, $scope.subject);
    }
    $scope.savesubject = function(subject) {
        console.log('1');
        // subject.uid = $scope.uid;
        console.log(subject);
        if (subject.id > 0) {
            Data.put('subjects/' + subject.id, subject).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(subject);
                    x.save = 'update';
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        } else {
            Data.post('subject', subject).then(function(result) {
                if (result.status != 'error') {
                    var x = angular.copy(subject);
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
