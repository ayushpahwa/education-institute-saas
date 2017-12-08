<div class="row">
  <div class="col-lg-12">
  <h3></i>Attendance View   <a class="btn btn-success pull-right" href="/myapp/#/attendance">Add New Attendance</a>
</h3>
</div>
</div>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel vertical-center"  style="padding:20px; margin:-2px;">
        <form class="form-inline" role="form">
        <h3>Search for a Class</h3>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Class</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="query.class" required="">
                <option value="">None</option>
                <option ng-repeat="class in divisions | orderBy:'name'" value="{{class.name}}">{{class.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Subject</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="query.subject" required="">
                <option value="">None</option>
                <option ng-repeat="subject in subjects | orderBy:'name'" value="{{subject.shortform}}">{{subject.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Batch</label><br>
            <div class="col-sm-10">
              <select class="form-control" ng-model="query.batch" required="">
                <option value="">None</option>
                <option ng-repeat="batch in batches | orderBy:'name'" value="{{batch.name}}">{{batch.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Date</label><br>
            <div class="col-sm-10">
              <input type="date" class="form-control" ng-model="query.date"  value="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>
        </form>
      </div><!-- /panel -->
    </div><!-- /col-lg-12 -->
  </div><!-- /row -->

  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel" style="padding:20px;">
        <h4>Attendance Records</h4>
        <section id="unseen">
          <br /><br />
          <table class="table table-bordered table-striped table-condensed">
            <thead>
              
              <tr>
                <th>S.No.</th>
                <th>Batch</th>
                <th>Date</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Percent</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in attendance | filter : query">
                <td>{{item.attendanceid}}</td>
                <td>{{item.batch}}</td>
                <td>{{item.date}}</td>
                <td>{{item.subject}}</td>
                <td>{{item.class}}</td>
                <td>{{item.percent}}</td>
                <td><button class="btn btn-sm btn-primary" ng-click="open(item)"><i class="fa fa-list"></i></button></td>
              </tr>
            </tbody>
          </table>
        </section>
      </div><!-- /panel -->
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->
