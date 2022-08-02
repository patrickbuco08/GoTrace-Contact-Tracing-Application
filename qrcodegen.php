<?php
  require_once 'config.php';
  if(!isset($_SESSION)){ session_start();}
  //session_start();

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
                  <h4 class="card-title">Location QR Code Generator</h4>
                  <small>Click on the link below to download:<br> <a href="GoTraceQRCodePosterTemplate.pptx">QR Code Template</a>,
                                              <a href="GoTrace-Resources-and-Template.pptx">GoTrace Resources and Template</a><br></small>
                  <!--QRcode Generator-->
                  <?php
                      //set it to writable location, a place for temp generated PNG files
                      $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;

                      //html PNG location prefix
                      $PNG_WEB_DIR = 'phpqrcode/temp/';

                       include "phpqrcode/qrlib.php";    
    
                        //ofcourse we need rights to create temp dir
                        if (!file_exists($PNG_TEMP_DIR))
                            mkdir($PNG_TEMP_DIR);
                        
                        $filename = $PNG_TEMP_DIR.'test.png';

                        //processing form input
                        //remember to sanitize user input in real-life solution !!!
                        $errorCorrectionLevel = 'L';
                        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
                            $errorCorrectionLevel = $_REQUEST['level'];    

                        $matrixPointSize = 4;
                        if (isset($_REQUEST['size']))
                            $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


                        if (isset($_REQUEST['data'])) { 
                        
                            //it's very important!
                            if (trim($_REQUEST['data']) == '')
                                die('data cannot be empty! <a href="?">back</a>');
                                
                            // user data
                            $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                            QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
                            
                        } else {    
                        
                            //default data
                            //echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
                            QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
                            
                        }    
                            
                        //display generated file
                        echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
                        
                        //config form
                        //<option value="http://gotrace.000webhostapp.com/reg.php?campus='. $_SESSION["campus"] .'">Registration</option>

                  ?>
             <form action="qrcodegen.php" method="post">     
                  <div class="form-group">
                    <label>Type <span style="color: red">*</span></label>

                   <?php
                   echo'<select onchange="myFunction(this.value)" id="type" class="form-control">
                      <option>Choose type</option>
                      <option value="http://gotrace.cvsuccatre.com/reg.php?campus='. $_SESSION["campus"] .'">Registration</option>
                      <option value="health">Health Survey</option>
                      <option value="area">Area in/out</option>
                      </select>';
                     ?>
                  </div>
<!--<option value="http://gotrace.cvsuccatre.com/healthsurvey.php?campus='. $_SESSION["campus"] .'">Health Survey</option>-->
                  <script>
                      function myFunction(x) {
                        if(x=="area"){
                           document.getElementById("divloc").style.display = "block";   
                           document.getElementById("data").value =  x;  
                        }else if(x=="health"){
                           document.getElementById("divloc").style.display = "block";   
                           document.getElementById("data").value =  x;  
                        }
                        else{
                           document.getElementById("divloc").style.display = "none";   
                           document.getElementById("data").value =  x;
                        }
                        document.getElementById("divloc").onchange;    
                      }
                    </script>      

                    <script>
                      function myFunction1(x) {
                        if(document.getElementById("type").value=='area'){
                          document.getElementById("data").value = "http://gotrace.cvsuccatre.com/contrace.php?campus="+ x;  
                        }else{
                          document.getElementById("data").value = "http://gotrace.cvsuccatre.com/healthsurvey.php?campus="+ x;
                        }
                                 
                        document.getElementById("data").onchange;               
                      }
                    </script> 

                  <div class="form-group" style="display:none" id="divloc" class="form-control">
                    <label>Location <span style="color: red">*</span></label>
                    <?php
                      echo'<select name="locid" class="form-control form-control-sm" onchange="myFunction1(this.value)" >
                        <option selected><?php echo $locid; ?></option>';
                    
                    $sqli="SELECT * FROM tbl_location";
                    $result=mysqli_query($link,$sqli);

                    while($row=mysqli_fetch_array($result)){
                        if(strcmp($locid, $row['locid'])==0){
                            continue;
                        }

                        $locid= $row['locid'];

                        $sql="SELECT * from tbl_location where locid='$locid'";
                            $res=mysqli_query($link,$sql);
                            while($row=mysqli_fetch_array($res)){
                                //echo '<option value="http://gotrace.cvsuccatre.com/contrace.php?campus='.$_SESSION["campus"].'&id='.$row['locid']. '">'.$row['locdesc'].'</option>';
                              echo '<option value="'.$_SESSION["campus"].'&id='.$row['locid']. '">'.$row['locdesc'].'</option>';
                            }
                       
                    }  
                    echo'</select>';
                    ?>
                  </div>

                  <div class="form-group">
                    <label>QR Code Link</label>
                    <?php echo'<input name="data" style="background-color:white" class="form-control form-control-sm" id="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'" />';?>
                  </div>

                  <div class="form-group">
                    <label>ECC <span style="color: red">*</span></label>
                    <?php
                      echo'<select name="level" class="form-control form-control-sm">
                          <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
                          <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
                          <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
                          <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
                      </select>';
                    ?>
                   </div>
                   
                   <div class="form-group">
                    <label>Size <span style="color: red">*</span></label>
                    <?php
                    echo'<select name="size" class="form-control form-control-sm"> ';

                     for($i=1;$i<=9;$i++)
                       echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
                    echo '</select>';
                    ?>
                 
                    </div>

                    <div class="form-group">
                    
                    <?php
                    echo'<input type="submit" value="GENERATE" class="btn btn-primary"><hr/>';
                    ?>
                 
                    </div>
                 

            </form>
                </div>
              </div>
            </div>
<!----------------------------------------------------------------------------------------------------->
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Locations Settings</h4>
<?php
  if($_SERVER["REQUEST_METHOD"]=="POST"){ 

    if(isset($_POST['add'])) {    
        $locdesc = $_POST['locdesc'];
    
        if(empty($locdesc)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Location name field is empty. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
          
        } else { 

         $result = mysqli_query($link,"SELECT * FROM tbl_location WHERE locdesc='$_POST[locdesc]'");
      	  $row = mysqli_fetch_array($result);   
      	  if(is_array($row)) {
      	  		echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Location name already exists. </div>
                  <script>
                      window.setTimeout(\"closeD();\", 5000);
                      function closeD(){
                      document.getElementById(\"d\").style.display=\"none\";
                    }
                  </script>
                  ";
      	  }else{
               $result=mysqli_query($link,"SELECT max(locid) FROM tbl_location");
               $count=mysqli_fetch_row($result);
               $locctr= $count[0] + 1;
                
                
                $result = mysqli_query($link, "INSERT INTO tbl_location VALUES('$locctr',UCASE('$locdesc'))");
                
                 echo"<div class=\"alert alert-success\" id=\"d\" style=\"display:block\"> New location added successfully. </div>
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
}

?>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal">
                    ADD LOCATION
                  </button>


<!-- Modal -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Location Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    <input type="text" name="locdesc" class="form-control form-control-sm" placeholder="Type location description" name="locdesc" >  
                  </div>
                  <div class="form-group">
                       <input type="submit" name="add" value="ADD" class="btn btn-info">
                  </div>
              </form>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------------------------------->
<hr>
<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
   if(isset($_POST['edit'])) {
        $new = $_POST['new'];
    
        if(empty($new)) {                
              echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> New Location name field is empty. </div>
              <script>
                  window.setTimeout(\"closeD();\", 5000);
                  function closeD(){
                  document.getElementById(\"d\").style.display=\"none\";
                }
              </script>
              ";
          
        }else{
           mysqli_query($link, "UPDATE tbl_location SET locdesc=UCASE('$_POST[new]') WHERE locid='$_POST[lid]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Location name updated successfully. </div>
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

        $result=mysqli_query($link,"SELECT count(*) FROM tbl_contracing where location='$_POST[locid]' ");
        $locctr=mysqli_fetch_row($result);

          
       if($locctr[0]=='0') {                
            mysqli_query($link, "DELETE FROM tbl_location WHERE locid='$_POST[locid]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> Location deleted successfully. </div>
            <script>
                window.setTimeout(\"closeD();\", 5000);
                function closeD(){
                document.getElementById(\"d1\").style.display=\"none\";
              }
            </script>
            ";
        }else{
          echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Cannot delete! location already in use. </div>
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
                        <table class="table" id="tblloc">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Description</th> 
                              <th>Action</th>        
                            </tr>
                          </thead>
                          <tbody>
                           <?php
                             $result = mysqli_query($link, "SELECT * FROM tbl_location");

                             while($res = mysqli_fetch_array($result)) {         
                                    echo "<tr>";
                                    echo "<td>".$res['locid']."</td>";
                                    echo "<td>".$res['locdesc']."</td>";
                                    echo '<td><button class="btn btn-light" data-toggle="modal" data-target="#EditModal'.$res['locid'].'" >Edit</button></td>';  
                                    //echo '<td><button class="btn btn-light" data-toggle="modal" data-target="#EditModal'.$res['locid'].'" >Edit</button>|<button class="btn btn-light" data-toggle="modal" data-target="#DeleteModal'.$res['locid'].'" >Delete</button></td>';   
                                    echo "</tr>";     
                              ?>
<!-- Edit Modal -->
<div class="modal fade" id="EditModal<?php echo $res['locid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Location Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form action="" method="post">
                  <div class="form-group">
                    
                    ID <input type="text" name="lid" value="<?php echo $res['locid']; ?>" class="form-control form-control-sm"> 

                    Description <br><input type="text" name="desc" value="<?php echo $res['locdesc']; ?>" class="form-control form-control-sm"> 

                    New Description
                    <input type="text" name="new" class="form-control form-control-sm" placeholder="Type location description" >  
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
<div class="modal fade" id="DeleteModal<?php echo $res['locid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <div class="form-group">
              ID <input type="text" name="locid" value="<?php echo $res['locid']; ?>" class="form-control form-control-sm"> 
              Description <br><input type="text" name="locdesc" value="<?php echo $res['locdesc']; ?>" class="form-control form-control-sm"> 
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

