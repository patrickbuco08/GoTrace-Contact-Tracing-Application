<?php
if(!isset($_SESSION)){ session_start();}
        if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
  if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
    if(isset($_POST['update'])) {
  
       $_SESSION['campus']= $_POST['change'];
       include_once 'config.php';

      echo "<script>location.reload();
      return false;
      </script>";
      
     }     
}   
       }
          


?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
          <a class="navbar-brand brand-logo" ><img src="./images/GoTrace-Color.png" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" ><img src="./images/gotrace.png" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>  
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
            <div class="input-group">
              <div class="input-group-prepend">
              </div>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-1">
          </li>
          <li class="nav-item dropdown mr-4">
          
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            
              <?php echo"<img src='./images/faces/". $_SESSION['img'] . "' alt='profile' />";?>
               <?php
              include_once 'config1.php';
                $result = mysqli_query($link1,"SELECT * FROM tbl_position WHERE posno = '$_SESSION[position]'");
                $row = mysqli_fetch_array($result);   

                $_SESSION['posdesc']=$row['posdesc'];
              ?>

              <span class="nav-profile-name"><?php echo $_SESSION['posdesc']; ?></span>

              <span class="nav-profile-name"><?php echo $_SESSION['fullname']; ?></span>
              <?php
               include_once 'config1.php';
                $result = mysqli_query($link1,"SELECT * FROM tbl_campus WHERE campno = '$_SESSION[campus]'");
                $row = mysqli_fetch_array($result);   

                $_SESSION['campdesc']=$row['campdesc'];
              ?>

              <span class="nav-profile-name"><?php echo "CvSU - ".  $_SESSION['campdesc'] ." Campus"; ?></span>
              
             
              
            </a>
           
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <?php
              include_once 'config1.php';
               if ($_SESSION['position']=='1' || $_SESSION['position']=='2')
                  echo' <a class="dropdown-item" data-toggle="modal" data-target="#ChangeCampus" >
                      <i class="mdi mdi-settings text-primary"></i>
                       Change Campus
                    </a>';
               ?>

              <a class="dropdown-item" href="logout.php">
                <i class="mdi mdi-logout text-primary"></i>
                Logout          
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>





<div class="modal fade" id="ChangeCampus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">Change Campus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
              <div class="signup-form"> 
       
    <form action="" method="post"> 
     


        <div class="form-group">
            <select name='change'  class='form-control'  required='required' >
          <?php
          
            

            $result = mysqli_query($link1,"SELECT * FROM tbl_campus");
               
            while($row=mysqli_fetch_array($result)){
              echo"<option value='". $row['campno']."' >".$row['campdesc']. "</option> ";

            }

            

          ?>  

          </select>
        </div>
      
     <div class="form-group">
            <input type="submit" name="update" class="btn btn-primary btn-block btn-lg" value="View Campus Record">
        </div>
    </form>
  
</div>
      </div>
    </div>
  </div>
</div>