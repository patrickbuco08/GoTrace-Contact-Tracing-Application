<?php
include_once 'config.php';

  if(!isset($_SESSION)){ session_start(); }//session_start();

  if(!isset($_SESSION['fullname'])){
    echo "<script>window.location.href = 'index.php';</script>";    
  }

  

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GoTrace Manage account</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="gotrace.ico" />

  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!--ratings-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once 'layout/navbar.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include_once 'layout/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
             

             <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Registered user management</h4>
                 
<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   if(isset($_POST['acceptaccount'])) {
         
           mysqli_query($link, "UPDATE tbl_reg SET regid='$_POST[newregid]', usertype='$_POST[usertype]', fullname='$_POST[fullname]',age='$_POST[age]', sex='$_POST[sex]', address='$_POST[address]',contactno='$_POST[contactno]',email='$_POST[email]',office='$_POST[office]' WHERE regid='$_POST[regid]'");
           mysqli_query($link, "UPDATE tbl_healthsurvey SET regid='$_POST[newregid]' WHERE regid='$_POST[regid]'");
           mysqli_query($link, "UPDATE tbl_contracing SET regid='$_POST[newregid]' WHERE regid='$_POST[regid]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> User information updated successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }     

   if(isset($_POST['mergeaccount'])) {
      

           mysqli_query($link, "UPDATE tbl_healthsurvey SET regid='$_POST[mergetoregid]' WHERE regid='$_POST[fromregid]'");
           mysqli_query($link, "UPDATE tbl_contracing SET regid='$_POST[mergetoregid]' WHERE regid='$_POST[fromregid]'");
           mysqli_query($link, "DELETE from tbl_reg  WHERE regid='$_POST[fromregid]'");
        
           echo"<div class=\"alert alert-warning\" id=\"d1\" style=\"display:block\"> Account successfully merge. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }           


    if(isset($_POST['deleteaccount'])) {
      
           mysqli_query($link, "DELETE from tbl_healthsurvey  WHERE regid='$_POST[delregid]'");
           mysqli_query($link, "DELETE from tbl_contracing  WHERE regid='$_POST[delregid]'");
           mysqli_query($link, "DELETE from tbl_reg  WHERE regid='$_POST[delregid]'");
        
           echo"<div class=\"alert alert-danger\" id=\"d1\" style=\"display:block\"> Account successfully deleted. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }      

    }
  ?>              
                  <div class="table-responsive">
                    <table class="table" id="tbluseracct">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>User type</th>
                          <th>Registration ID</th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Sex</th>
                          <th>Address</th>
                          <th>Contact no.</th>
                          <th>Email address</th>
                          <th>Office/Department</th>
                        </tr>
                      </thead>
                      <tbody>

                         <?php
                             $result = mysqli_query($link, "SELECT * from tbl_reg");

                             while($res = mysqli_fetch_array($result)) {         
                                    echo "<tr>";
                                    echo "<td>"; 
                                    echo '<button class="btn btn-light" data-toggle="modal" data-target="#Editregacct'.$res['regid'].'" ><span class="mdi mdi-grease-pencil"></span></button><button class="btn btn-light" data-toggle="modal" data-target="#Mergeacct'.$res['regid'].'" ><span class="mdi mdi-account-multiple-outline"></span></button><button class="btn btn-light" data-toggle="modal" data-target="#Deleteacct'.$res['regid'].'" ><span class="mdi mdi-delete-variant"></span></button>';  "</td>";


                                    $sql="SELECT userdesc FROM tbl_usertype where userid= '$res[usertype]'";
                                    $output = mysqli_query($link, $sql);
                                    while ($rec = mysqli_fetch_array($output)) {
                                      $userdesc=$rec['userdesc'];

                                    }


                                    echo "<td>".$userdesc."</td>";
                                    echo "<td>".$res['regid']."</td>";
                                    echo "<td>".$res['fullname']."</td>";
                                    echo "<td>".$res['age']."</td>";
                                    echo "<td>".$res['sex']."</td>";
                                    echo "<td>".$res['address']."</td>";
                                    echo "<td>".$res['contactno']."</td>";
                                    echo "<td>".$res['email']."</td>";
                                    echo "<td>".$res['office']."</td>";
                                    
                                    //echo '<td>'. $res['allow'] .'<button class="btn btn-light" data-toggle="modal" data-target="#Editacctstat'.$res['empno'].'" ><span class="mdi mdi-grease-pencil"></span></button></td>';   
                                   
                                    echo "</tr>";
                              ?>

<!-- Edit Modal -->
<div class="modal fade" id="Editregacct<?php echo $res['regid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    Registration ID 
                    <input type="text" name="regid" value="<?php echo $res['regid']; ?>" style="border:none; visibility: none" >   
                    <input type="text" name="newregid" value="<?php echo $res['regid']; ?>" class="form-control form-control-sm" >   
                  </div>
                  <div class="form-group">
                    User type
                    <select name="usertype"  class="form-control" >
                          <?php
                                                  
                            $r = mysqli_query($link,"SELECT * FROM tbl_usertype");
                               
                            while($rr=mysqli_fetch_array($r)){
                              if ($res['usertype']==$rr['userid']) {echo"<option value='". $rr['userid']."' selected>".$rr['userdesc']. "</option> ";}
                              else{echo"<option value='". $rr['userid']."'>".$rr['userdesc']. "</option> ";}
                            }
                          ?>  
                   </select>
                     Name
                     <input type="text" name="fullname" value="<?php echo $res['fullname']; ?>" class="form-control form-control-sm" > 
                     Age
                     <input type="number" name="age" value="<?php echo $res['age']; ?>" class="form-control form-control-sm" >
                     Sex
                     <select name="sex" class="form-control">
                      <option value="M" <?php if ($res['sex']=='M') echo"selected"; ?>>Male</option>
                      <option  value="F" <?php if ($res['sex']=='F') echo"selected"; ?>>Female</option>
                     </select>

                     Address
                     <input type="text" name="address" value="<?php echo $res['address']; ?>" class="form-control form-control-sm" >
                     Contact no.
                     <input type="tel" pattern="[0-9]{11}" minlength="11" maxlength="11" name="contactno" value="<?php echo $res['contactno']; ?>" class="form-control form-control-sm" >
                     Email Address
                     <input type="email" name="email" value="<?php echo $res['email']; ?>" class="form-control form-control-sm" >
                     Office/Department
                     <input type="text" name="office" value="<?php echo $res['office']; ?>" class="form-control form-control-sm" >

                  </div>

                  <div class="form-group">
                       <input type="submit" name="acceptaccount" class="btn btn-info" value="Update Account">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="Mergeacct<?php echo $res['regid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Merge account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    Registration ID 
                    <input type="text" name="fromregid" value="<?php echo $res['regid']; ?>" style="border:none" >   
                   
                  </div>
                  <div class="form-group">
                     Merge to this registered id.
                     <input type="text" name="mergetoregid"  class="form-control form-control-sm" >

                  </div>

                  <div class="form-group">
                       <input type="submit" name="mergeaccount" class="btn btn-info" value="Merge" onclick="return  confirm('Do you want to merge Y/N')" >
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="Deleteacct<?php echo $res['regid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    Registration ID 
                    <input type="text" name="delregid" value="<?php echo $res['regid']; ?>" style="border:none" >            
                  </div>

                  <div class="form-group">
                       <input type="submit" name="deleteaccount" class="btn btn-info" value="Delete" onclick="return  confirm('Do you want to delete Y/N')" >
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>


                              <?php      
                                }     
                              ?>

                            <script>
                             $(document).ready(function() {
                                  $('#tbluseracct').DataTable();
                              } );
                           </script>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>


          
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include_once 'layout/footer.php'; ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <script src="js/jquery.dataTables.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>
  <!-- End custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>

