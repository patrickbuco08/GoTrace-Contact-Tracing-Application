<?php
  include_once 'config.php';
  if(!isset($_SESSION)){ session_start();}
  //session_start();

  if(($_SESSION['position']=='1') && ($_SESSION['campus']=='9')){
 //if($_SESSION['position']<>'1'){
   echo "<script>window.location.href = 'index1.php';</script>";  
 }

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
  <title>GoTrace Dashboard</title>
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
                  <h4 class="card-title">User type</h4>
<?php
  if($_SERVER["REQUEST_METHOD"]=="POST"){ 

    if(isset($_POST['add'])) {    
        $userdesc = $_POST['userdesc'];
    
        if(empty($userdesc)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> User type field is empty. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
          
        } else { 

           $result=mysqli_query($link,"SELECT count(*) FROM tbl_usertype");
           $count=mysqli_fetch_row($result);
           $userid= $count[0] + 1;
           if(isset($_POST['userauto'])){$userauto='1';}else{$userauto='0';} 
           
            
            $result = mysqli_query($link, "INSERT INTO tbl_usertype VALUES('$userid','$userdesc','$userauto','0')");
            
             echo"<div class=\"alert alert-success\" id=\"d\" style=\"display:block\"> New User type added successfully. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                      document.getElementById(\"d\").style.display=\"none\";
                  }
              </script>
              ";
        }
    }
}

?>

<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
   
  if(isset($_POST['edit'])) {
        $newuserdesc = $_POST['newuserdesc'];
        if(isset($_POST['userauto'])){$userauto='1';}else{$userauto='0';} 
    
        if(empty($newuserdesc)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> User description field is empty. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
          
        }else{
           mysqli_query($link, "UPDATE tbl_usertype SET userdesc='$_POST[newuserdesc]', userauto='$userauto' WHERE userid='$_POST[userid]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> User description updated successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }     
     }  

    if(isset($_POST['delete'])) {

        $result=mysqli_query($link,"SELECT count(*) FROM tbl_reg where usertype='$_POST[userid]' ");
        $useridctr=mysqli_fetch_row($result);

          
       if($useridctr[0]=='0') {                
            mysqli_query($link, "DELETE FROM tbl_usertype WHERE userid='$_POST[userid]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> User type deleted successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 10000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }else{
          echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Cannot delete! user type already in use. </div>
              <script>
                  window.setTimeout(\"closeD();\", 10000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
           
        }     
     }             
  }
?>

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Addusertype">
                    ADD USER TYPE
                  </button>


<!-- Modal -->
<div class="modal fade" id="Addusertype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">

                    <input type="text" name="userdesc" class="form-control form-control-sm" placeholder="User type description" >
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="userauto"> ID Auto Increment 
                  </div>
                  <div class="form-group">
                       <input type="submit" name="add" value="ADD" class="btn btn-info">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>


<div class="table-responsive">
                        <table class="table" id="tblloc">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Description</th> 
                              <th>Auto</th>   
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php
                             $result = mysqli_query($link, "SELECT * FROM tbl_usertype");

                             while($res = mysqli_fetch_array($result)) {         
                                    echo "<tr>";
                                    echo "<td>".$res['userid']."</td>";
                                    echo "<td>".$res['userdesc']."</td>";
                                    echo "<td>".$res['userauto']."</td>";

                                    echo '<td><button class="btn btn-light" data-toggle="modal" data-target="#EditUType'.$res['userid'].'" >Edit</button>|<button class="btn btn-light" data-toggle="modal" data-target="#DeleteUType'.$res['userid'].'" >Delete</button></td>';   
                                    echo "</tr>";     
                              ?>
<!-- Edit Modal -->
<div class="modal fade" id="EditUType<?php echo $res['userid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    
                    ID <input type="text" name="userid" value="<?php echo $res['userid']; ?>" class="form-control form-control-sm"> 

                    Description <br><input type="text" name="userdesc" value="<?php echo $res['userdesc']; ?>" class="form-control form-control-sm"> 
                    New Description <br><input type="text" name="newuserdesc"  class="form-control form-control-sm"> 
                    <input type="checkbox" name="userauto" <?php if($res['userauto']==1){echo'checked';}?> >  Auto-increment

                  </div>
                        <div class="form-group">
                       <input type="submit" name="edit" class="btn btn-info" value="EDIT">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteUType<?php echo $res['userid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <div class="form-group">
              ID <input type="text" name="userid" value="<?php echo $res['userid']; ?>" class="form-control form-control-sm"> 
              Description <br><input type="text" name="userdesc" value="<?php echo $res['userdesc']; ?>" class="form-control form-control-sm"> 
            </div>
                  <div class="form-group">
                 <input type="submit" name="delete" class="btn btn-info" value="DELETE">
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
                                  $('#tblloc').DataTable();
                              } );
                           </script>

                          </tbody>
                        </table>
                      </div>
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

