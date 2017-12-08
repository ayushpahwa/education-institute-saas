  <div class="row">
    <div class="col-lg-12">
      <h3>Student's Test</h3>
    </div>
  </div>

  <div class="row mt">
    <div class="col-md-4">
      <div class="panel vertical-center"  style="padding:20px; margin:-2px;">
        <h3>Add New Test</h3>
        <hr>
        <form  role="form">
          <!-- <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Name</label><br>
            <div class="col-sm-10">
              <input type="text" class="form-control input-sm" ng-model="name">
            </div>
          </div>
 -->          <div class="form-group">
            <label for="">Class</label>
            <select  ng-disabled="submitted" class="form-control" ng-model="class" required="">
              <option value="">None</option>
              <option ng-repeat="class in divisions | orderBy:'name'" value="{{class.name}}">{{class.name}}</option>
              
            </select>
          </div>
          
          <div class="form-group">
            <label for="">Subject</label>
            <select  ng-disabled="submitted" class="form-control" ng-model="subject" required="">
              <option value="">None</option>
              <option ng-repeat="subject in subjects | orderBy:'name'" value="{{subject.shortform}}">{{subject.name}}</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="">Batch</label>
            <select  ng-disabled="submitted" class="form-control" ng-model="batch" required="">
              <option value="">None</option>
              <option ng-repeat="batch in batches | orderBy:'name'" value="{{batch.name}}">{{batch.name}}</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="">Date</label>
            <input  ng-disabled="submitted" type="date" class="form-control" ng-model="date"  value="<?php echo date('Y-m-d'); ?>">
          </div>
          <div class="form-group">
            <label for="">Maximum Marks</label>
            <input  ng-disabled="submitted" type="number" class="form-control input-sm" ng-model="mm">
          </div>
          
          <br>
          <button class="btn  btn-success"  ng-hide="submitted" ng-click="do()">Submit</button>
        </form>
      </div><!-- /panel -->
    </div><!-- /col-lg-12 -->

    <div class="col-md-8"  ng-show="submitted">
      <div class="panel" style="padding:20px;">
        <h4>Add Student's Marks</h4>
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
              <tr ng-repeat="student in students | orderBy :'name'">
                <td >{{student.id}}</td>
                <td>{{student.name}}</td>
                <td><input type="text" ng-model="marks[student.id]"/></td>
              </tr>
            </tbody>
          </table>
          <button class="btn btn-primary" ng-click="send()">Submit</button>
        </section>
      </div><!-- /panel -->
    </div><!-- /col-lg-4 -->
  </div><!-- /row -->
