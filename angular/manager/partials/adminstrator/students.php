  <div class="row">
    <div class="col-lg-12">
  <h3>Student's Attendance</h3>
  <a class="btn btn-default btn-large pull-right" href="/panel/attendance/#/view">View Attendance</a>
    </div>
  </div>

  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel vertical-center"  style="padding:20px; margin:-2px;">
        <form class="form-inline" role="form">
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Class</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="class" required="">
                <option value="">None</option>
                <option ng-repeat="class in divisions | orderBy:'name'" value="{{class.name}}">{{class.name}}</option>
                
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Subject</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="subject" required="">
                <option value="">None</option>
                <option ng-repeat="subject in subjects | orderBy:'name'" value="{{subject.shortform}}">{{subject.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Batch</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="batch" required="">
                <option value="">None</option>
                <option ng-repeat="batch in batches | orderBy:'name'" value="{{batch.name}}">{{batch.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Date</label><br>
            <div class="col-sm-10">
              <input type="date" class="form-control" ng-model="date"  value="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>
          <button class="btn  btn-success" ng-click="do()">Submit</button>
        </form>
      </div><!-- /panel -->
    </div><!-- /col-lg-12 -->
  </div><!-- /row -->



  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel" style="padding:20px;">
        <h4>Add Attendance</h4>
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
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->
