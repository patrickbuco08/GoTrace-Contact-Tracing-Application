<?php
   if(!isset($_SESSION)){ session_start();}//session_start();


  //if(isset($_SESSION['fullname'])){
  //  echo "<script>window.location.href = 'index1.php';</script>";    
  //}
//$_SESSION['campus'] = '9';
//include_once 'config.php';
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
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>

<?php
//LOGIN
if(isset($_POST['submit'])){
    $_SESSION['campus'] = '9';
    include_once 'config.php';
  $result = mysqli_query($link,"SELECT * FROM tbl_acct WHERE user='$_POST[uname]' and pass = md5('$_POST[psw]') and allow='1'");
  $row = mysqli_fetch_array($result);   
  if(is_array($row)) {
        if($row['sex']=='F'){
           $_SESSION['img'] = 'female.svg';
        }else{
           $_SESSION['img'] = 'male.svg';
        }
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['position'] = $row['position'];
      $_SESSION['campus']= $row['campus'];
      
      
      //Filter the accounts 3-technical, 4 nurse, 5 hr
      if($row['position']==3){
          echo"<script> 
            window.location='qrcodegen.php';
          </script>";
      }elseif($row['position']==5){
          echo"<script> 
            window.location='listreg.php';
          </script>";
      }else{
          echo"<script> 
            window.location='index1.php';
          </script>";
      }
      exit();   
  } else{
      echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Invalid Username or Password </div>
          <script>
              window.setTimeout(\"closeD();\", 10000);
              function closeD(){
              document.getElementById(\"d\").style.display=\"none\";
            }
          </script>
      ";
  }
      
}
?>

              
              <form action="" method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Username" required="required" name="uname" pattern="[^'\\x22]+" title="Invalid input">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Password" required="required"  name="psw">
                </div>
                <div class="mt-3">
                  <input type="submit" name="submit" class="btn btn-info btn-block" value="Log in" style="border-style:none; background-color:#00b300;">
                </div>
                
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account?<br> Contact us: <!--<a href="register.php" class="text-primary">Create</a>-->
                  <a href="mailto:ccatre@cvsu.edu.ph" class="text-primary">ccatre@cvsu.edu.ph</a>
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

