<div class="row">
  <div class="col-lg-12">
    <h3>Test View</h3>
    <a class="btn btn-default btn-large pull-right" href="/myapp/#/test">Add New Test</a>
  </div>

  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel vertical-center"  style="padding:20px; margin:-2px;">
        <form class="form-inline" role="form">
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Name</label><br>
            <div class="col-sm-10">
              <input type="text" class="form-control input-sm" ng-model="query.name">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Class</label><br>
            <div class="col-sm-10">
              <select class="form-control input-sm" ng-model="query.class" required="">
                <option value="">None</option>
               <option ng-repeat="class in divisions | orderBy:'name'" value="{{class.name}}">{{class.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Subject</label><br>
            <div class="col-sm-10">
              <select class="form-control input-sm" ng-model="query.subject" required="">
                <option value="">None</option>
                <option ng-repeat="subject in subjects | orderBy:'name'" value="{{subject.shortform}}">{{subject.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Batch</label><br>
            <div class="col-sm-10">
              <select class="form-control input-sm" ng-model="query.batch" required="">
                <option value="">None</option>
                <option ng-repeat="batch in batches | orderBy:'name'" value="{{batch.name}}">{{batch.name}}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Date</label><br>
            <div class="col-sm-10">
              <input type="date" class="form-control input-sm" ng-model="query.date"  value="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Maximum Marks</label><br>
            <div class="col-sm-10">
              <input type="number" class="form-control input-sm" ng-model="query.mm">
            </div>
          </div>
        </form>
      </div><!-- /panel -->
    </div><!-- /col-lg-12 -->
  </div><!-- /row -->


</div>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="panel" style="padding:20px;">
        <h4>Test Records</h4>
        <section id="unseen">
          <br /><br />
          <table class="table table-bordered table-striped table-condensed">
            <thead>
              
              <tr>
                <th>S.No.</th>
                <th>Test Details</th>
                <th>Batch</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Date</th>
                <th>Maximum Marks</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in test | filter : query  ">
                <td>{{item.testid}}</td>
                <td>{{item.name}}</td>
                <td>{{item.batch}}</td>
                <td>{{item.subject}}</td>
                <td>{{item.class}}</td>
                <td>{{item.date}}</td>
                <td>{{item.mm}}</td>
                <td><button class="btn btn-sm btn-primary" ng-click="open(item)"><i class="fa fa-list"></i></button></td>
              </tr>
            </tbody>
          </table>
        </section>
      </div><!-- /panel -->
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->
