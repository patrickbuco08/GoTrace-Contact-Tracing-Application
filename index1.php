<?php
  if(!isset($_SESSION)){ session_start(); }//session_start();

  if(!isset($_SESSION['fullname'])){
    echo "<script>window.location.href = 'index.php';</script>";    
  }
  if($_SERVER["REQUEST_METHOD"]=="POST"){ 
   
    if(isset($_POST['update'])) {
  
       $_SESSION['campus']= $_POST['change'];
       include_once 'config.php';

      echo "<script>location.reload();
      return false;
      </script>";
      
     }     
}

  include_once 'config.php';
  $url1=$_SERVER['index1.php'];
  header("Refresh: 60; URL=$url1");   //auto refresh code

  date_default_timezone_set('Asia/Manila');
  $today = strtotime(date("y-m-d h:i:sa"));
  $day=date("Y-m-d", $today);
  //$day= date("Y-m-d", $today);
                    
  //charts
  $ctr=$ctrdate=$cough=$sore=$breath=$diarrhea=$pains=$prox=$travelled=0;


   $result = mysqli_query($link,"SELECT * FROM tbl_healthsurvey WHERE hdate='$day'");
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){
        $ctrdate++;
          if( $row["cough"]==1){$cough=$cough+1;}
          if( $row["sore"]==1){$sore=$sore+1;}
          if( $row["breathing"]==1){$breath=$breath+1;}
          if( $row["diarrhea"]==1){$diarrhea=$diarrhea+1;}
          if( $row["bodypains"]==1){$pains=$pains+1;}
          if( $row["closeprox"]==1){$prox=$prox+1;}
          if( $row["travelled"]==1){$travelled=$travelled+1;}
          $ctr++;
       }
     }


if($_SERVER["REQUEST_METHOD"]=="POST"){ 
  if (isset($_POST['submit'])) {
  $ctr=$ctrdate=$cough=$sore=$breath=$diarrhea=$pains=$prox=$travelled=0;
  $result = mysqli_query($link,"SELECT * FROM tbl_healthsurvey WHERE hdate='$_POST[day]'");
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){
        $ctrdate++;
          if( $row["cough"]==1){$cough=$cough+1;}
          if( $row["sore"]==1){$sore=$sore+1;}
          if( $row["breathing"]==1){$breath=$breath+1;}
          if( $row["diarrhea"]==1){$diarrhea=$diarrhea+1;}
          if( $row["bodypains"]==1){$pains=$pains+1;}
          if( $row["closeprox"]==1){$prox=$prox+1;}
          if( $row["travelled"]==1){$travelled=$travelled+1;}
          $ctr++;
       }
     }
     $day=$_POST['day'];
  }
   
}


$dataPoints1 = array(
  array("label"=> "Cough", "y"=> $cough),
  array("label"=> "Sore Throat", "y"=> $sore),
  array("label"=> "Difficulty of Breathing", "y"=> $breath),
  array("label"=> "Diarrhea", "y"=> $diarrhea),
  array("label"=> "Body Pains", "y"=> $pains),
  array("label"=> "Close proximity", "y"=> $prox),
  array("label"=> "travelled outside Cavite", "y"=> $travelled)
);
 
$dataPoints2 = array(
  array("label"=> "Cough", "y"=> $ctrdate-$cough),
  array("label"=> "Sore Throat", "y"=> $ctrdate-$sore),
  array("label"=> "Difficulty of Breathing ", "y"=> $ctrdate-$breath),
  array("label"=> "Diarrhea ", "y"=> $ctrdate-$diarrhea),
  array("label"=> "Body Pains", "y"=> $ctrdate-$pains),
  array("label"=> "Close proximity ", "y"=> $ctrdate-$prox),
  array("label"=> "Travelled outside Cavite", "y"=> $ctrdate-$travelled)
);
 
;


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="gotrace.ico" />
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

  <!--charts -->
  <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
  title: {
    //text: "Spending of Money Based on Household Composition"
    text: "HEALTH SURVEY"
  },
  theme: "light2",
  animationEnabled: true,
  toolTip:{
    shared: true,
    reversed: true
  },
  axisY: {
    title: "Percentage (%)"
  },
  axisX: {
    title: "COVID-19 signs, symptoms, history of exposure"
  },
  legend: {
     horizontalAlign: "right", // left, center ,right 
     verticalAlign: "top"  // top, center, bottom
    },
  data: [
    {
      color: "rgba(255,12,32,.5)",
      type: "stackedColumn100",
      name: "Yes",
      showInLegend: true,
      yValueFormatString: "##0 ",
      dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    },{
      color: "rgba(0,135,147,.5)",
      type: "stackedColumn100",
      name: "No",
      showInLegend: true,
      yValueFormatString: "##0 ",
      dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    }
  ]
});
 
chart.render();
 
}

</script>

<!--new code-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 12px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 12px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>


</head>
<body >
  <div <style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(19,134,40,1) 0%, rgba(137,205,76,1) 100%); ">
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
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="false">As of: <?php echo $day; ?></a>
                    </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <!--<div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Date</small>
                                <h5 class="mb-0 d-inline-block"><?php //echo $day;?></h5>
                          </div>
                        </div>-->
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">


                  <a data-toggle="modal" data-target="#Reg" title="click the icon to view the list of registered users">
                      <i class="mdi mdi-clipboard-account mr-3 icon-lg text-success"></i> 
                  </a>
 <!--<i class="mdi mdi-clipboard-account mr-3 icon-lg text-success"></i>-->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Registered users</small>
                            <?php
                                if ($result = mysqli_query($link, "SELECT count(*) FROM tbl_reg")) {
                                  // Fetch one and one row
                                  while ($row = mysqli_fetch_row($result)) {
                                    $reguser= $row[0];
                                  }
                                  echo"<h5 class=\"mr-2 mb-0\">".$reguser."</h5>";
                                }
                            ?>
                          </div>
                 

<div class="modal fade" id="Reg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">Registered users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

<table id="myTable">
  <tr class="header">
    <th style="width:70%;">Name</th>
    <th style="width:20%;">ID No</th>
    <th style="width:10%;">User Type</th>
  </tr>
 
  <?php
   $ctr1=0;
    $result = mysqli_query($link,"SELECT * FROM tbl_reg");
    if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_array($result)){
      $ctr1=$ctr1+1;
  ?>
  
  <tr>
         <td><?php echo $row["fullname"]; ?></td>  
         <td><?php echo $row["regid"]; ?></td>  
         <td>
             <?php
             $query = mysqli_query($link,"SELECT userdesc FROM tbl_usertype WHERE userid='$row[usertype]' ");
                $output = mysqli_fetch_array($query);
                if(is_array($output)) {
                    echo $output["userdesc"]; 
                } 
            ?>
         </td>
         
  </tr>

        <?php  } 
        } 
        ?>
</table>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
      </div>
    </div>
  </div>
</div>


                         
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                <a data-toggle="modal" data-target="#user" title="click the icon to view the list of registered users">
                      <i class="mdi mdi-heart mr-3 icon-lg text-warning"></i> 
                  </a>

                         <!-- <i class="mdi mdi-heart mr-3 icon-lg text-warning"></i>-->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Active users</small>
                            <?php
                                if ($result = mysqli_query($link, "SELECT count(*) FROM tbl_healthsurvey where hdate='$day'")) {
                                  // Fetch one and one row
                                  while ($row = mysqli_fetch_row($result)) {
                                    $activeuser= $row[0];
                                  }
                                  echo"<h5 class=\"mr-2 mb-0\">".$activeuser."</h5>";
                                }
                            ?>
                            
                          </div>


<div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">Active users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           
<table id="myTable">
  <tr class="header">
    <th style="width:20%;">ID no.</th>
    <th style="width:80%;">Fulname</th>
    
  </tr>
 
  <?php
    $ctr2=0;
    $result = mysqli_query($link,"SELECT * FROM tbl_healthsurvey where hdate='$day'");
    if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_array($result)){
      $ctr2=$ctr2+1;
  ?>
  
  <tr>
         <td><?php echo $row["regid"]; ?></td>  
          <td>
            <?php
             $result0 = mysqli_query($link,"SELECT fullname FROM tbl_reg WHERE regid='$row[regid]' ");
                $row0 = mysqli_fetch_array($result0);
                if(is_array($row0)) {
                    echo $row0["fullname"]; 
                } 
            ?>
          </td>
         
  </tr>

        <?php  } 
        } 
        ?>
</table>


      </div>
    </div>
  </div>
</div>






                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                  <a data-toggle="modal" data-target="#loc" title="click the icon to view the list of registered users">
                      <i class="mdi mdi-map-marker-radius mr-3 icon-lg text-primary"></i> 
                  </a>

                         <!-- <i class="mdi mdi-map-marker-radius mr-3 icon-lg text-primary"></i>-->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Active locations</small>
                            <?php
                                if ($result = mysqli_query($link, "SELECT count(DISTINCT location) as loc FROM tbl_contracing where hdate='$day'")) {
                                  // Fetch one and one row
                                  while ($row = mysqli_fetch_row($result)) {
                                    $locvisit= $row[0];
                                  }
                                  echo"<h5 class=\"mr-2 mb-0\">".$locvisit."</h5>";
                                }
                            ?>
                          </div>
                        </div>


<div class="modal fade" id="loc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">Active locations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           
<table id="myTable">
  <tr class="header">
    <th style="width:20%;">Location</th>
    <th style="width:20%;">Visit count</th>
    
  </tr>
 
  <?php
    $ctr3=0;
    //$result = mysqli_query($link,"SELECT DISTINCT location as locid, count(location) as loc FROM tbl_contracing where hdate='$day'");
    $result = mysqli_query($link,"SELECT location, count(location) as loc FROM tbl_contracing where hdate='$day' GROUP BY location");
    
    if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_array($result)){
      $ctr3=$ctr3+1;
  ?>
  
  <tr>
         
          <td>
            <?php
             //$result0 = mysqli_query($link,"SELECT locdesc FROM tbl_location WHERE locid='$row[locid]' ");
             $result0 = mysqli_query($link,"SELECT locdesc FROM tbl_location WHERE locid='$row[location]' ");
                $row0 = mysqli_fetch_array($result0);
                if(is_array($row0)) {
                    echo $row0["locdesc"]; 
                } 
            ?>
          </td>
          <td><?php echo $row["loc"]; ?></td>  
         
  </tr>

        <?php  } 
        } 
        ?>
</table>


      </div>
    </div>
  </div>
</div>
                        
                         <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                  <a data-toggle="modal" data-target="#hightemp" title="click the icon to view the list of registered users">
                      <i class="mdi mdi-thermometer mr-3 icon-lg text-danger"></i> 
                  </a>

                         <!-- <i class="mdi mdi-thermometer mr-3 icon-lg text-danger"></i>-->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">High Temperature</small>
                            <?php
                                if ($result = mysqli_query($link, "SELECT count(*) FROM tbl_healthsurvey where temp>'37.5' and hdate='$day'")) {
                                  // Fetch one and one row
                                  while ($row = mysqli_fetch_row($result)) {
                                    $hightemp= $row[0];
                                  }
                                  echo"<h5 class=\"mr-2 mb-0\">".$hightemp."</h5>";
                                }
                            ?>
                          </div>
                        </div>

<div class="modal fade" id="hightemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">High Temperature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           
<table id="myTable">
  <tr class="header">
    <th style="width:20%;">ID no</th>
    <th style="width:60%;">Fullname</th>
    <th style="width:20%;">Temperature</th>
    
  </tr>
 
  <?php
    $ctr4=0;
    $result = mysqli_query($link,"SELECT regid, temp FROM tbl_healthsurvey where temp>'37.5' and hdate='$day'");
    if(mysqli_num_rows($result) > 0){
     while($row = mysqli_fetch_array($result)){
      $ctr4=$ctr4+1;
  ?>
  
  <tr>
          <td><?php echo $row["regid"]; ?></td>  
          <td>
            <?php
             $result0 = mysqli_query($link,"SELECT fullname FROM tbl_reg WHERE regid='$row[regid]' ");
                $row0 = mysqli_fetch_array($result0);
                if(is_array($row0)) {
                    echo $row0["fullname"]; 
                } 
            ?>
          </td>
          <td><?php echo $row["temp"]; ?></td>  
         
  </tr>

        <?php  } 
        } 
        ?>
</table>


      </div>
    </div>
  </div>
</div>




                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
 <a data-toggle="modal" data-target="#symp" title="click the icon to view the list of registered users">
          <i class="mdi mdi-pulse mr-3 icon-lg text-info"></i> 
</a>
                         <!-- <i class="mdi mdi-pulse mr-3 icon-lg text-info"></i>-->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Symptoms</small>
                            <?php
                              $ctrsymp=0;
                              $result = mysqli_query($link,"SELECT * FROM tbl_healthsurvey WHERE hdate='$day'");
                              if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    if( $row["cough"]==1 || $row["sore"]==1 || $row["breathing"]==1 || $row["diarrhea"]==1 || $row["bodypains"]==1 || $row["closeprox"]==1 || $row["travelled"]==1){$ctrsymp++; $empno[]=$row["regid"]; 
                                    }
                                 }
                                 
                               }
                               echo"<h5 class=\"mr-2 mb-0\">".$ctrsymp."</h5>";
                             

                            ?>
                          </div>
                        </div>


<div class="modal fade" id="symp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include_once 'config1.php'; ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="exampleModalLabel">Symptoms</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           
<table id="myTable">
  <tr class="header">
    <th style="width:20%;">ID no</th>
    <th style="width:60%;">Fullname</th>   
  </tr>
 
<?php
    $x=0;
      while($ctrsymp >0) {

    
?>

 
  <tr>
          <td><?php echo $empno[$x]; ?></td>  
          <td>
            <?php
             $result0 = mysqli_query($link,"SELECT fullname FROM tbl_reg WHERE regid='$empno[$x]' ");
                $row0 = mysqli_fetch_array($result0);
                if(is_array($row0)) {
                    echo $row0["fullname"]; 
                } 
            ?>
          </td>
         
  </tr>

        <?php  
        $x++;
        $ctrsymp--;
       }
        ?>
</table>


      </div>
    </div>
  </div>
</div>







                      </div>
                    </div>
                   

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
                  <!--<canvas id="cash-deposits-chart"></canvas>-->
                  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                  <div id="chartContainer" style="height: 50px; width: 100%;text-align: center"><?php echo"n=".$ctr; ?></div>
                  <form action="" method="POST">
                    <input type="date" name="day" value="<?php echo $day; ?>" max="<?php echo $today; ?>">
                    <input type="submit" name="submit"  class="btn btn-primary" value="Display" >
                   
                  </form>

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
</div>
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

