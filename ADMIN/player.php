<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Users</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">    
  </head>
  <body>

    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">AdminStrap</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Dashboard</a></li>
            <li><a href="promoter.php">Promoter</a></li>            
            <li class="active"><a href="player.php">Player</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Welcome, Brad</a></li>
            <li><a href="login.html">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Users<small>Manage Site Users</small></h1>
          </div>          
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li><a href="index.html">Dashboard</a></li>
          <li class="active">Player</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container-fluid">
        <div class="row">
          
          <?php include 'sidebar.php'; ?>

          <div class="col-md-10">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Player</h3>
              </div>
              <div class="panel-body">
                <div class="row">                     
                </div>
                <br>

                <div class="removeMessages"></div>                 
 
                <br /> <br /> <br />
                <table id="manageMemberTable" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th>SL</th>
                          <th>NAME</th>
                          <th>EMAIL</th>
                          <th>IMAGE</th>
                          <th>PHONE</th>                          
                          <th>ACTIVE</th>
                          <th>ACTION.</th>                          
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <!-- //////////TABLE DATA GOES HERE//////////// -->                         
                         
                      </tr>
                  </tbody>
                </table>
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>


    <footer id="footer">
      <p>Copyright Next Tech Soft Solution Pvt. Ltd. &copy; 2018</p>
    </footer>

    <!-- Modals -->

  <!-- remove modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span> Remove Member</h4>
    </div>
    <div class="modal-body">
    <p>Do you really want to remove ?</p>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="removeBtn">Save changes</button>
    </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /remove modal -->




  <!-- edit modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editMemberModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Edit Player</h4>
        </div>

    <form class="form-horizontal" action="php_action/edit_player.php" method="POST" id="updateMemberForm">       

        <div class="modal-body">
            
          

        <div class="form-group"> <!--/here teh addclass has-error will appear -->
          <label for="editName" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10"> 
            <input type="text" class="form-control" id="editName" name="editName" placeholder="Name" disabled="true">
        <!-- here the text will apper  -->
          </div>
        </div>

        <div class="form-group">
          <label for="editEmail" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editSocial" class="col-sm-2 control-label">Social No</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editSocial" name="editSocial" placeholder="Social No" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editPhone" class="col-sm-2 control-label">Phone</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editPhone" name="editPhone" placeholder="Contact" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editPaytm" class="col-sm-2 control-label">Paytm</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editPaytm" name="editPaytm" placeholder="Paytm" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editBank" class="col-sm-2 control-label">Bank</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editBank" name="editBank" placeholder="Bank" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editBankAc" class="col-sm-2 control-label">Bank Ac</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editBankAc" name="editBankAc" placeholder="Bank Ac" disabled="true">
          </div>
        </div>

        <div class="form-group">
          <label for="editBankIfsc" class="col-sm-2 control-label">IFSC</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editBankIfsc" name="editBankIfsc" placeholder="Bank IFSC" disabled="true">
          </div>
        </div>
        
        
        <div class="form-group">
          <label for="editPoint" class="col-sm-2 control-label">Point</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="editPoint" name="editPoint" placeholder="Point" disabled="true">
          </div>
        </div>
        <div class="form-group">
          <label for="editActive" class="col-sm-2 control-label">Active</label>
          <div class="col-sm-10">
            <select class="form-control" name="editActive" id="editActive">
              <option value="">~~SELECT~~</option>
              <option value="1">Activate</option>
              <option value="0">Deactivate</option>
            </select>
          </div>
        </div>  
        </div>
        <div class="modal-footer editMemberModal">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /edit modal -->   


    <!-- view modal -->
  <div class="modal fade col-md-12" tabindex="-1" role="dialog" id="viewMemberModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> View Player Details</h4>
        </div>

    <form class="form-horizontal" action="" method="" id="updateMemberForm">       

        <div class="modal-body">

          <table id="viewMemberTable" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
              <thead>
                  <tr>
                     
                  </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>NAME</td>                    
                    <td><input type="text" id="viewName" disabled="true"></td>
                  </tr> 
                  <tr>
                    <td>EMAIL</td>
                    <td><input type="text" id="viewEmail" disabled="true"></td>
                  </tr> 

                  <tr>
                  <td>SOCIAL NO</td>
                  <td><input type="text" id="viewSocial" disabled="true"></td> 
                  </tr>

                  <tr>
                  <td>PHONE</td>
                  <td><input type="text" id="viewPhone" disabled="true"></td>
                  </tr>

                  <tr>
                  <td>PAYTM</td>
                  <td><input type="text" id="viewPaytm" disabled="true"></td>
                  </tr> 

                  <tr>
                  <td>BANK</td>
                  <td><input type="text" id="viewBank" disabled="true"></td> 
                  </tr>

                  <tr>
                  <td>BANK AC</td>
                  <td><input type="text" id="viewBankAc" disabled="true"></td>
                  </tr>

                  <tr>
                  <td>BANK IFSC</td>
                  <td><input type="text" id="viewIfsc" disabled="true"></td>
                  </tr>

                  <tr>
                  <td>POINT</td> 
                  <td><input type="text" id="viewPoint" disabled="true"></td>                
                  </tr>

                  <tr>
                  <td>AMOUNT</td> 
                  <td><input type="text" id="viewAmount" disabled="true"></td>                
                  </tr>
              </tbody>
          </table>
        
        </div>
        <div class="modal-footer editMemberModal">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>          
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /view modal -->   



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dataTables.responsive.min.js"></script>
    <script src="js/responsive.bootstrap.min.js"></script>
    <script src="custom/js/player.js"></script>
  </body>
</html>
