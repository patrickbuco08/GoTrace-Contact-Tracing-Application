<?php
   if(!isset($_SESSION)){ session_start();}//session_start();

$_SESSION['campus'] = '9';
include_once 'config.php';

 if(!isset($_GET['fname'])){
    echo "<script>window.location.href = 'index.php';</script>";    
  }
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GoTrace</title>
  
  
  <meta property="og:site_name" content="GoTrace" /> <!-- website name -->
  <meta property="og:site" content="https://gotrace.cvsuccatre.com/" /> <!-- website link -->
  <meta property="og:title" content="GoTrace"/> <!-- title shown in the actual shared post -->
  <meta property="og:description" content="CvSU Contact Tracing App" /> 
  
  
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="gotrace.ico" />
</head>

<body style="background-color:green;">
  <div class="container-scroller" >
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo" >
                <a href="index.php"><img src="WiTR-rectangle-2.png" style="width:100% align:center;" alt="GoTace"></a>
              </div>
              <h4>Hello! <?php echo $_GET['fname'];?></h4>
              <h6 class="font-weight-light">You may change your password here.</h6>


<?php
 if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   if(isset($_POST['btnchangepass'])) {
       
           
           mysqli_query($link, "UPDATE tbl_acct SET pass = md5('$_POST[newpsw]') WHERE empno='$_GET[empno]'");
          
           echo"<div class=\"alert alert-success\" id=\"d1\" style=\"display:block\"> You've successfully changed your password. </div>
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
      
              <form action="" method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Username" value="<?php echo $_GET['empno']; ?>" disabled>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="New password" name="newpsw">
                </div>
                <div class="mt-3">
                  <input type="submit" name="btnchangepass" class="btn btn-info btn-block" value="Save" style="border-style:none; background-color:#00b300;">
                </div>
                
               
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
</body>

</html>

