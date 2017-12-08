app.controller('portalCtrl', function ($scope, $rootScope, $modal,$sce, $filter, Data) {
  $scope.iframe="";
  console.log($scope.firstName);
  $rootScope.id = 1;
  $scope.trustSrc = function(src) {
    return $sce.trustAsResourceUrl(src);
  }
  $scope.Dater = function(){
   return new Date($scope.child.feemonth).setMonth($scope.child.feemonth.getMonth()+8);
};
  Data.getad('studetails', $scope.firstName).then(function(data){   
   $scope.child = data.data[0];
//   $scope.child.feemonth = $scope.child.feemonth+"-10";
//	$scope.child.feemonth = new Date($scope.child.feemonth);
  // $scope.child.feemonth =   new Date($scope.child.feemonth).setMonth($scope.child.feemonth.getMonth()+8);
   
    $scope.class = data.data[0].class;
    $scope.batch = data.data[0].batch;
    $scope.range =  new Array($scope.child.feetype);
    console.log($scope.class);
    switch ($scope.class) {
    
     case '9th':
        $scope.iframe = $sce.trustAsResourceUrl("https://www.google.com/calendar/embed?src=4j73q6u6h0mvos2i0ginpjpn30%40group.calendar.google.com&ctz=Asia/Calcutta");
        break;
    case '10th':
        $scope.iframe = $sce.trustAsResourceUrl("https://www.google.com/calendar/embed?title=Class%2010th%20Timetable&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=calendar%40malhotrasclasses.in&amp;color=%231B887A&amp;ctz=Asia%2FCalcutta");
        break;
    case '11th':
        $scope.iframe = $sce.trustAsResourceUrl("https://www.google.com/calendar/embed?title=Class%2010th%20Timetable&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=j20o294o4fav5li7fl7cfqi4b8%40group.calendar.google.com&amp;color=%238D6F47&amp;ctz=Asia%2FCalcutta");
        break;
    case '12th':
        $scope.iframe = $sce.trustAsResourceUrl("https://www.google.com/calendar/embed?title=Class%2010th%20Timetable&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=c08f2p35nd7uvcegubq03eh1f4%40group.calendar.google.com&amp;color=%23691426&amp;ctz=Asia%2FCalcutta");
        break;
}
    Data.getad('portalAS',$scope.class).then(function(data){
      $scope.assignments = data.data;
    }); 
    console.log($scope.assignments);

    Data.get('portalnortifications').then(function(data){
      $scope.nortifications = data.data;
    });
console.log($scope.nortifications);
    Data.getad('portalAD',$rootScope.id).then(function(data){
      $scope.tests = data.data;
      var a=0;
      for(var i = 0; i < $scope.tests.length; i++){
            $scope.tests[i].percent= ($scope.tests[i].marks/$scope.tests[i].mm)*100; 
      }
      });
    Data.getad('portalattendance',$rootScope.id).then(function(data){
      $scope.attendance = data.data;
      var a=0;
      $scope.attendpercent=0;
      for(var i = 0; i < $scope.attendance.length; i++){
            if ($scope.attendance[a].attendance=="Present") 
            {
              $scope.attendpercent++;
        $scope.showpercent = ($scope.attendpercent*100)/$scope.attendance.length; 
            };
            a++;
       
      }
        
    });
  });});