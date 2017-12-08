<div class="row">
  <div class="col-lg-12">
    <h3>Performace Dashboard
    </h3>
  </div>
</div>
<style>
.material-icons.md-48 { font-size: 40px; }
</style>
<div  class="row mt">
  <div  class="col-md-6">
    
    <div ng-repeat="item in nortifications" class="alert {{item.type}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>{{item.title}} - </strong> {{item.message}}
    </div>
    <div class="panel panel-success ">
      <div class="panel-heading">
        <center>
        <h4><i class="material-icons md-48">assignment</i><br><strong>Attendance</strong></h4>
        </center>
      </div>
      <div class="panel-body" >
        <a >
          <div class="task-info">
            <div class="desc">Net Attendance</div>
            <div class="percent">{{showpercent | number:2}}%</div>
          </div>
          <div class="progress progress-striped">
            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: {{showpercent}}%">
              <span class="sr-only">{{showpercent}}% Complete</span>
            </div>
          </div>
        </a>
      </div>
      <div style="max-height: 400px;overflow: auto;">
        <table class="table">
          <thead>
            <tr class="filters">
              <th>ID </th>
              <th>Subject </th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="item in attendance | orderBy : 'id'">
              <td>{{item.attendanceid}}</td>
              <td>{{item.subject}}</td>
              <td>{{item.date}}</td>
              <td>{{item.attendance}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div><!-- /col-lg-12 -->
    <div class="col-md-6">
      <div class="panel panel-primary" >
        <div class="panel-heading">
          <center>
          <h4><i class="material-icons md-48">assessment</i><br><strong style="color:white;">Results</strong></h4>
        </center>            </div>
        <div class="panel-body">
          
          <div class="custom-bar-chart">
            <ul class="y-axis">
              <li><span>100%</span></li>
              <li><span>80</span></li>
              <li><span>60%</span></li>
              <li><span>40%</span></li>
              <li><span>20%</span></li>
              <li><span>00%</span></li>
            </ul>
            <div class="bar"  ng-repeat="item in tests | limitTo: 7 | orderBy : 'id'">
              <div class="title">{{item.testid}}</div>
              <div class="value tooltips" data-original-title="8.500" data-toggle="tooltip" data-placement="top" style="height: {{item.percent}}%;"></div>
            </div>

          </div>
        </div>
        <div style="max-height: 400px;overflow: auto; ">
          <table class="table">
            <thead>
              <tr class="filters">
                <th>ID </th>
                <th>Name </th>
                <th>Subject</th>
                <th>Your Marks</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in tests| orderBy : 'testid'">
                <td>{{item.testid}}</td>
                <td>{{item.date}}</td>
                <td>{{item.subject}}</td>
                <td><center>{{item.marks}}/{{item.mm}}</center></td>
              </tr>

            </tbody>
          </table>
          </div><!-- /form-panel -->
          </div><!-- /form-panel -->
          </div><!-- /form-panel -->
          </div><!-- /col-lg-12 -->
          <div class="row">

            <div class="col-md-6">
              <div class="panel panel-warning vertical-center"  >
                <div class="panel-heading">
                  <center>
                  <h1><i class="material-icons md-48">assignment_turned_in</i><br><small>Assignments</small></h1>
                  </center>
                </div>
                <table class="table">
                  <thead>
                    <tr class="filters">
                      <th>ID </th>
                      <th>Name </th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="item in assignments | orderBy : 'id'">
                      <td>{{item.id}}</td>
                      <td>{{item.name}}</td>
                      <td> <a class="btn btn-success" href="http://malhotrasclasses.in/panel/assignments/files/{{item.id}}.pdf">View </a></td>
                    </tr>

                  </tbody>
                </table>
                </div><!-- /form-panel -->
                </div><!-- /col-lg-12 -->
                <div class="col-xs-12 col-md-6">
                  <div class="panel panel-primary vertical-center"  >
                    <div class="panel-heading">
                      <center>
                      <h1><i class="material-icons md-48">perm_contact_calendar</i><br><small style="color:white;">Calendar</small></h1>
                      </center>
                    </div>
                    <iframe data-ng-src="{{iframe}}" style=" border-width:0 " width="100%" height="400" frameborder="0" scrolling="no"></iframe>            
                  </div>
                </div>
                
              </div>