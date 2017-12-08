  <div class="row">
    <div class="col-lg-12">
      <h3>Student's Attendance</h3>
      <a class="btn btn-default btn-large pull-right" href="../myapp/#/attendenceView">View Attendance</a>
    </div>
  </div>

  <div class="row mt">
    <div class="col-md-4">
      <div class="panel vertical-center"  style="padding:20px; margin:-2px;">
        <h3>Add New Attendance</h3>
        <hr>
      <form role="form">
          
              <div class="form-group">
                <label for="">Class</label>
              <select ng-disabled="submitted" class="form-control" ng-model="class" >
                <option value="">None</option>
                <option ng-repeat="class in divisions | orderBy:'name'" value="{{class.name}}">{{class.name}}</option>
                
              </select>
              </div>
         
              <div class="form-group">
                <label for="">Subject</label>
              <select ng-disabled="submitted" class="form-control" ng-model="subject" required="">
                <option value="">None</option>
                <option ng-repeat="subject in subjects | orderBy:'name'" value="{{subject.shortform}}">{{subject.name}}</option>
              </select>
              </div>
          
              <div class="form-group">
                <label for="">Batch</label>
              <select ng-disabled="submitted" class="form-control" ng-model="batch" required="">
                <option value="">None</option>
                <option ng-repeat="batch in batches | orderBy:'name'" value="{{batch.name}}">{{batch.name}}</option>
              </select>
              </div>
       
              <div class="form-group">
                <label for="">Date</label>
              <input type="date" ng-disabled="submitted" class="form-control" ng-model="date"  value="<?php echo date('Y-m-d'); ?>">
              </div>
         
          <button class="btn  btn-success" ng-hide="submitted" ng-click="do()">Submit</button>
        </form>
      </div><!-- /panel -->
    </div><!-- /col-lg-12 -->

    <div class="col-md-8" ng-show="submitted">
      <div class="panel" style="padding:20px;">
        <h4>Mark Absent Students</h4>
        <section id="unseen">
          <br /><br />
          <table class="table table-bordered table-striped table-condensed">
            <thead>
              <tr>
                <th>S.No.</th>
                <th>Name Of the Student</th>
                <th class="numeric">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="student in students | orderBy:'name'">
                <td >{{student.id}}</td>
                <td>{{student.name}}</td>
                <td>
                  <label class="radio-inline">
                    <input type="radio" value="Present" checked="checked" ng-model="presentStudents[student.id]">Present
                  </label>
                  <label class="radio-inline">
                    <input type="radio" value="Absent" ng-model="presentStudents[student.id]">Absent
                  </label> 
                </td>
              </tr>
            </tbody>
          </table>
          <button class="btn  btn-primary" ng-click="send()">Submit Attendance</button>
        </section>
      </div><!-- /panel -->

    </div><!-- /row -->
  </div><!-- /row -->
