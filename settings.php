<?php
  include_once 'config.php';

  if(!isset($_SESSION)){ session_start();}//session_start();


if(($_SESSION['position']=='1') && ($_SESSION['campus']<>'9')){
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
             <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

<h4 class="card-title">AREA OF IMPLEMENTATION</h4>
<?php
  if($_SERVER["REQUEST_METHOD"]=="POST"){ 

    if(isset($_POST['addcampus'])) {    
        $campdesc = $_POST['campdesc'];
    
        if(empty($campdesc)) {                
              echo"<div class=\"alert alert-danger\" id=\"d1\" style=\"display:block\"> Area description field is empty. </div>
              <script>
                  window.setTimeout(\"closeD1();\", 5000);
                  function closeD1(){
                  document.getElementById(\"d1\").style.display=\"none\";
                }
              </script>
              ";
          
        } else { 

           $result=mysqli_query($link,"SELECT count(*) FROM tbl_campus");
           $count=mysqli_fetch_row($result);
           $campno= $count[0] + 1;

             $result = mysqli_query($link, "INSERT INTO tbl_campus VALUES('$campno','$campdesc')");

             /*Auto create database
                 $conn = mysqli_connect('localhost', 'cvsuc006_Wdo0Qd', 'cvsu2020');
                 
                 if(!$conn ) {
                    die('Could not connect: ' . mysqli_error());
                 }
                 
                 $sql = "CREATE Database ". 'dbcontacttracing'.$campno ;
                 $retval = mysqli_query( $conn,$sql );
                 
                 if(!$retval ) {
                    
                  echo"<div class=\"alert alert-danger\" id=\"d1\" style=\"display:block\"> ". die('Could not create database: ' . mysqli_error()) ." </div>
                      <script>
                          window.setTimeout(\"closeD1();\", 5000);
                          function closeD1(){
                          document.getElementById(\"d1\").style.display=\"none\";
                        }
                      </script>
                      ";
                 }else{
                 
                 echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Database ".$campdesc." created successfully! </div>
                    <script>
                        window.setTimeout(\"closeD1();\", 5000);
                        function closeD1(){
                            document.getElementById(\"d1\").style.display=\"none\";
                        }
                    </script>
                    ";
                 }
                 mysqli_close($conn);
              
              // until here */

            echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Area description created successfully! </div>
                    <script>
                        window.setTimeout(\"closeD1();\", 5000);
                        function closeD1(){
                            document.getElementById(\"d1\").style.display=\"none\";
                        }
                    </script>
                    ";
             
        }
    }
}
?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Addcampus">
          ADD AREA
        </button>


<!-- Modal Add Usetype -->
<div class="modal fade" id="Addcampus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    <input type="text" name="campdesc" class="form-control form-control-sm" placeholder="Area description" >
                  </div>
                  <div class="form-group">
                       <input type="submit" name="addcampus" value="ADD" class="btn btn-info">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>

 <hr>
<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
   if(isset($_POST['editcampus'])) {
        $newcampus = $_POST['newcampus'];
    
        if(empty($newcampus)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> New Area description field is empty. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
          
        }else{
           mysqli_query($link, "UPDATE tbl_campus SET campdesc='$_POST[newcampus]' WHERE campno='$_POST[campno]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Area description updated successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }     
     }  


    if(isset($_POST['deletecampus'])) {

        $result=mysqli_query($link,"SELECT count(*) FROM tbl_acct where campus='$_POST[campno]' ");
        $campnoctr=mysqli_fetch_row($result);

          
       if($campnoctr[0]=='0') {                
            mysqli_query($link, "DELETE FROM tbl_campus WHERE campno='$_POST[campno]'");

            /*Auto delete database
             $conn = mysqli_connect('localhost', 'cvsuc006_Wdo0Qd', 'cvsu2020');
                 
                 if(!$conn ) {
                    die('Could not connect: ' . mysqli_error());
                 }
                 
                 $sql = "DROP Database ". 'dbcontacttracing'.$_POST['campno'] ;
                 $retval = mysqli_query( $conn,$sql );


                  if(!$retval ) {
                    
                  echo"<div class=\"alert alert-danger\" id=\"d1\" style=\"display:block\"> ". die('Could not delete the database: ' . mysqli_error()) ." </div>
                      <script>
                          window.setTimeout(\"closeD1();\", 5000);
                          function closeD1(){
                          document.getElementById(\"d1\").style.display=\"none\";
                        }
                      </script>
                      ";
                 }else{
                 
                 echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Database deleted successfully! </div>
                    <script>
                        window.setTimeout(\"closeD1();\", 5000);
                        function closeD1(){
                            document.getElementById(\"d1\").style.display=\"none\";
                        }
                    </script>
                    ";
                 }
                 mysqli_close($conn);*/
                 
            echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Area deleted successfully! </div>
                    <script>
                        window.setTimeout(\"closeD1();\", 5000);
                        function closeD1(){
                            document.getElementById(\"d1\").style.display=\"none\";
                        }
                    </script>
                    ";     
        }else{
          echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Cannot delete! area already in use. </div>
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
                      <div class="table-responsive">
                        <table class="table" id="tblcampus">
                          <thead>
                            <tr>
                              <th>Area ID</th>
                              <th>Description</th> 
                              <th>Action</th> 
                            </tr>
                          </thead>
                          <tbody>
                           <?php
                             $result = mysqli_query($link, "SELECT * FROM tbl_campus");

                             while($res = mysqli_fetch_array($result)) {         
                                    echo "<tr>";
                                    echo "<td>".$res['campno']."</td>";
                                    echo "<td>".$res['campdesc']."</td>";
                                    
                                    echo '<td><button class="btn btn-light" data-toggle="modal" data-target="#EditCampus'.$res['campno'].'" >Edit</button>|<button class="btn btn-light" data-toggle="modal" data-target="#DeleteCampus'.$res['campno'].'" >Delete</button></td>';   
                                    echo "</tr>";     
                              ?>
<!-- Edit Modal -->
<div class="modal fade" id="EditCampus<?php echo $res['campno']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    
                    Area ID <input type="text" name="campno" value="<?php echo $res['campno']; ?>" class="form-control form-control-sm"> 

                    Description <br><input type="text" name="campdesc" value="<?php echo $res['campdesc']; ?>" class="form-control form-control-sm"> 
                    New Description <br><input type="text" name="newcampus"  class="form-control form-control-sm"> 
                    

                  </div>
                        <div class="form-group">
                       <input type="submit" name="editcampus" class="btn btn-info" value="EDIT">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteCampus<?php echo $res['campno']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <div class="form-group">
              Area ID <input type="text" name="campno" value="<?php echo $res['campno']; ?>" class="form-control form-control-sm"> 
              Description <br><input type="text" name="campdesc" value="<?php echo $res['campdesc']; ?>" class="form-control form-control-sm"> 
            </div>
                  <div class="form-group">
                 <input type="submit" name="deletecampus" class="btn btn-info" value="DELETE">
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
                                  $('#tblcampus').DataTable();
                              } );
                           </script>

                          </tbody>
                        </table>
                      </div>         

<!-------------------------------------------------------------Evaluation Code--------------------------------
  <h4 class="card-title">Evaluation Feedback</h4>
            
 <form action="" method="post">     
    <div class="form-group">
      <label>Set Evaluation date </label>
          /*<?php
           /* if($_SERVER["REQUEST_METHOD"]=="POST"){ 
                if(isset($_POST['seteval'])) {    
                    $dateeval = $_POST['dateeval'];
                
                    if(empty($dateeval)) {                
                          echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Date field is empty. </div>
                          <script>
                              window.setTimeout(\"closeD();\", 5000);
                              function closeD(){
                              document.getElementById(\"d\").style.display=\"none\";
                            }
                          </script>
                          ";              
                    } else {                        
                        $result = mysqli_query($link, "INSERT INTO tbl_evaldate VALUES('$dateeval')");                      
                         echo"<div class=\"alert alert-success\" id=\"d\" style=\"display:block\"> Evaluation date set successfully. </div>
                          <script>
                              window.setTimeout(\"closeD();\", 5000);
                              function closeD(){
                                  document.getElementById(\"d\").style.display=\"none\";
                              }
                          </script>
                          ";
                    }
                }
          }*/
          ?>*/

          <input type="date" name="dateeval" class="form-control form-control-sm"  >
   </div>
      <div class="form-group">             
        <input type="submit"  name="seteval" value="SET Evaluation" class="btn btn-primary">
      </div>
</form>
----------------------------------------------------UNTIL Here---------------------------------------------------->
                </div>
              </div>
            </div>
<!-----------------------------------------------------USER TYPE-------------------------------------------------->
            <div class="col-md-6 grid-margin stretch-card">
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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Addusertype">
          ADD USER TYPE
        </button>


<!-- Modal Add Usetype -->
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
<!---------------------------------------------PHP UPDATE / DELETE USERTYPE------------------------------------------->
<hr>
<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
   if(isset($_POST['edit'])) {
        $newuserdesc = $_POST['newuserdesc'];
        if(isset($_POST['userauto'])){$userauto='1';}else{$userauto='0';} 
    
        if(empty($newuserdesc)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> New user description field is empty. </div>
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
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }else{
          echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Cannot delete! user type already in use. </div>
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
                      <div class="table-responsive">
                        <table class="table" id="tblusertype">
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
                                    //echo "<td>".$res['userauto']."</td>";
                                    echo "<td>"; 
                                    if($res['userauto']==1)
                                        echo"Yes";
                                    else
                                        echo"No";
                                    echo "</td>"; 

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
                                  $('#tblusertype').DataTable();
                              } );
                           </script>

                          </tbody>
                        </table>
                      </div>
              </div>
           </div>            
       </div>


             <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Account Lists</h4>
                  <p class="card-description">
                   To activate the account <code>change access into YES</code>
                  </p>
<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   if(isset($_POST['acceptaccount'])) {
       
        if(isset($_POST['allow'])){$allow='1';}else{$allow='0';} 
    
           mysqli_query($link, "UPDATE tbl_acct SET allow='$allow', position= '$_POST[position]' WHERE empno='$_POST[empno]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Account registered successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }   

        if(isset($_POST['deleteaccount'])) {
      
           mysqli_query($link, "DELETE from tbl_acct  WHERE empno='$_POST[empno]'");
       
        
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
                    <table class="table" id="tblacct">
                      <thead>
                        <tr>
                          <th>Access</th>
                          <th>Campus</th>
                          <th>Position</th>
                          <th>Employee ID</th>
                          <th>Username</th>
                          <th>Fullname</th>
                          <th>Email Address</th>
                        </tr>
                      </thead>
                      <tbody>

                         <?php
                             $result = mysqli_query($link, "SELECT tbl_acct.*, tbl_position.posdesc, tbl_campus.campdesc FROM tbl_acct, tbl_position, tbl_campus where tbl_acct.position=tbl_position.posno and tbl_acct.campus=tbl_campus.campno");

                             while($res = mysqli_fetch_array($result)) {         
                                    echo "<tr>";
                                    echo "<td>"; 
                                    if($res['allow']==1)
                                        echo"Yes";
                                    else
                                        echo"No";
                                    echo '<button class="btn btn-light" data-toggle="modal" data-target="#Editacctstat'.$res['empno'].'" ><span class="mdi mdi-grease-pencil"></span></button> <button class="btn btn-light" data-toggle="modal" data-target="#changepasslink'.$res['empno'].'" ><span class="mdi mdi-account-key"></span></button></button></td>';  
                                    echo "<td>".$res['campdesc']."</td>";
                                    echo "<td>".$res['posdesc']."</td>";
                                    echo "<td>".$res['empno']."</td>";
                                    echo "<td>".$res['user']."</td>";
                                    echo "<td>".$res['fullname']."</td>";
                                    
                                    
                                    //echo '<td>'. $res['allow'] .'<button class="btn btn-light" data-toggle="modal" data-target="#Editacctstat'.$res['empno'].'" ><span class="mdi mdi-grease-pencil"></span></button></td>';   
                                    echo "<td>".$res['email']."</td>";
                                    echo "</tr>";
                              ?>

<!-- Edit Modal -->
<div class="modal fade" id="Editacctstat<?php echo $res['empno']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Allow account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    EmpID 
                    <input type="text" name="empno" value="<?php echo $res['empno']; ?>" style="border:none" >   
                    Access 
                    <input type="checkbox" name="allow" <?php if($res['allow']==1){echo'checked';}?> > 
                    </div>
                    <div class="form-group">
                    Level
                    <select name="position"  class="form-control" >
                          <?php
                                                  
                            $r = mysqli_query($link,"SELECT * FROM tbl_position");
                               
                            while($rr=mysqli_fetch_array($r)){
                              if ($res['posdesc']==$rr['posdesc']) {echo"<option value='". $rr['posno']."' selected>".$rr['posdesc']. "</option> ";}
                              else{echo"<option value='". $rr['posno']."'>".$rr['posdesc']. "</option> ";}
                            }
                          ?>  
                   </select>

                  </div>
                        <div class="form-group">
                       <input type="submit" name="acceptaccount" class="btn btn-info" value="Update">
                       <input type="submit" name="deleteaccount" class="btn btn-info" value="Delete" onclick="return  confirm('Do you want to delete Y/N')" >
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="changepasslink<?php echo $res['empno']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change passwork link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    Copy this link and send it to your user.
                    <input type="text" name="empno" value="<?php echo 'https://gotrace.cvsuccatre.com/changepass.php?empno='.$res['empno'].'&fname='.$res['user']; ?>"  class="form-control form-control" onClick="this.select();">   
                   
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
                                  $('#tblacct').DataTable();
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

