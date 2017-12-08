
app.controller('attendenceCtrl', function($scope, $modal, $filter, Data) {
    $scope.submitted = false;
    $scope.student = {};
    Data.get('subjects').then(function(data) {
        $scope.subjects = data.data;
    });
    Data.get('divisions').then(function(data) {
        $scope.divisions = data.data;
    });
    Data.get('batches').then(function(data) {
        $scope.batches = data.data;
    });
    $scope.do = function() {
    $scope.submitted = true;
        Data.get('studentsBatch' + '/' + $scope.class + '/' + $scope.batch + '/' + $scope.subject).then(function(data) {
            $scope.students = data.data;
        });
    };


    $scope.presentStudents = {};

    $scope.attendance = {};

    $scope.send = function() {
        $scope.attendance.batch = $scope.batch;
        $scope.attendance.class = $scope.class;
        $scope.attendance.subject = $scope.subject;
        $scope.attendance.date = $scope.date;

        var pres = 0;
        for (var l = 0; l < $scope.students.length; l++) {
            var att = {};
            att.studentid = $scope.students[l].id;
            if ($scope.presentStudents[att.studentid] == 'Present') {
                pres++;
            }

        }
        console.log(pres);
        console.log($scope.students.length);
        $scope.attendance.percent = (pres / $scope.students.length) * 100;


        Data.post('attendance', $scope.attendance).then(function(result) {
            if (result.status != 'error') {
                Data.getbatch('lastid' + '/' + $scope.class + '/' + $scope.batch + '/' + $scope.subject).then(function(data) {
                    $scope.attendanceId = data.data;
                    var details = [];
                    console.log($scope.presentStudents);
                    for (var j = 0; j < $scope.students.length; j++) {
                        var detail = {};
                        detail.attendanceid = $scope.attendanceId[0].attendanceid;
                        detail.studentid = $scope.students[j].id;
                        detail.name = $scope.students[j].name;
                        detail.attendance = $scope.presentStudents[detail.studentid];

                        console.log(detail);
                        details.push(detail);
                        Data.post('attendetails', detail).then(function(results) {
                            if (result.status != 'error') {} else {
                                console.log(results);
                            }
                        });
                    }
                });
            } else {
                console.log(result);
            }
        });
        alert("Submission Succesful");
    };

    $scope.deleteFtudent = function(student) {
        if (confirm("Are you sure to remove the student")) {
            Data.delete("students/" + student.id).then(function(result) {
                $scope.students = _.without($scope.students, _.findWhere($scope.students, { id: student.id }));
            });
        }
    };
    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/teacher/attendenceEdit.html',
            controller: 'attendenceEditCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });
        modalInstance.result.then(function(selectedObject) {
            if (selectedObject.save == "insert") {
                $scope.students.push(selectedObject);
                $scope.students = $filter('orderBy')($scope.students, 'id', 'reverse');
            } else if (selectedObject.save == "update") {
                p.phone = selectedObject.phone;
                p.eid = selectedObject.eid;
                p.father = selectedObject.fn;
                p.mother = selectedObject.mn;
                p.class = selectedObject.class;
                p.contact = selectedObject.cn;
                p.batch = selectedObject.bn;
            }
        });
    };

    $scope.columns = [
        { text: "ID", predicate: "id", sortable: true, dataType: "number" },
        { text: "Name", predicate: "name", sortable: true },
        { text: "E-mail ID", predicate: "eid", sortable: true },
        { text: "Phone", predicate: "phone", sortable: true, dataType: "number" },
        { text: "Father's Name", predicate: "fn", sortable: true },
        { text: "Mother's Name", predicate: "mn", sortable: true },
        { text: "Contact Number", predicate: "cn", sortable: true, dataType: "number" },
        { text: "Class", predicate: "class", reverse: true, sortable: true, dataType: "number" },
        { text: "Batch", predicate: "batch", sortable: true },
        { text: "Action", predicate: "", sortable: false }
    ];

});


app.controller('attendenceViewCtrl', function($scope, $modal, $filter, Data) {
    $scope.attendance = {};
    Data.get('attendance').then(function(data) {
        $scope.attendance = data.data;
    });
    Data.get('subjects').then(function(data) {
        $scope.subjects = data.data;
    });
    Data.get('divisions').then(function(data) {
        $scope.divisions = data.data;
    });
    Data.get('batches').then(function(data) {
        $scope.batches = data.data;
    });

    $scope.open = function(p, size) {
        var modalInstance = $modal.open({
            templateUrl: 'partials/teacher/attendenceViewer.html',
            controller: 'attendenceOrderViewCtrl',
            size: size,
            resolve: {
                item: function() {
                    return p;
                }
            }
        });

    };

});
app.controller('attendenceOrderViewCtrl', function($scope, $modalInstance, item, Data) {

    $scope.order = angular.copy(item);
    $scope.orderitems = {};
    console.log(item.attendanceid);
    $scope.attendetails = {};
    Data.get('attendetails/' + item.attendanceid).then(function(data) {
        $scope.attendetails = data.data;
        console.log($scope.attendetails);
    });

    $scope.cancel = function() {
        $modalInstance.dismiss('Close');
    };
    $scope.title = 'View ATTENDANCE';

    var original = item;
    $scope.isClean = function() {
        return angular.equals(original, $scope.order);
    }

});
