<?php
 require_once "config.php";   
     if(!isset($_SESSION)){ session_start();}
      $ctr=0;

      date_default_timezone_set('Asia/Manila');
      $today = strtotime(date("y-m-d h:i:sa"));
      $hdate= date("Y-m-d", $today);

      //SELECT `regid`, `timein`, `timeout` FROM `tbl_contracing` where `location`='7' and `hdate`='2020-09-07'
      //SELECT `tbl_reg`.`regid`,`tbl_reg`.`fullname`, `tbl_contracing`.`timein`, `tbl_contracing`.`timeout` FROM `tbl_contracing`,`tbl_reg` where `tbl_contracing`.`location`='7' and `tbl_contracing`.`hdate`='2020-09-07' and `tbl_contracing`.`regid`=`tbl_reg`.`regid`

      $query="SELECT tbl_reg.regid, tbl_reg.fullname, tbl_contracing.location, tbl_contracing.timein, tbl_contracing.timeout FROM tbl_contracing, tbl_reg where  tbl_contracing.hdate='$hdate' and tbl_contracing.regid=tbl_reg.regid";

      $loc='*';
      $dtfrm=$hdate;


      if($_SERVER["REQUEST_METHOD"]=="POST"){ 
        if (isset($_POST['filter'])) {
              
          if($_POST['location']<>'*'){
              $query="SELECT tbl_reg.regid, tbl_reg.fullname, tbl_contracing.location, tbl_contracing.timein, tbl_contracing.timeout FROM tbl_contracing, tbl_reg where tbl_contracing.location='$_POST[location]' and tbl_contracing.hdate='$_POST[dtfrm]' and tbl_contracing.regid=tbl_reg.regid";
              
              
              $dtfrm=$_POST['dtfrm'];
          }else if ($_POST['location']=='*'){
              $query="SELECT tbl_reg.regid, tbl_reg.fullname, tbl_contracing.location, tbl_contracing.timein, tbl_contracing.timeout FROM tbl_contracing, tbl_reg where tbl_contracing.hdate='$_POST[dtfrm]' and tbl_contracing.regid=tbl_reg.regid";
              
             
              $dtfrm=$_POST['dtfrm'];
          }
              
        }

        if (isset($_POST['clear'])) {
          
            $dtfrm=$hdate;    
        }

     }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="gotrace.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

   <!-- Open Graph data -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="assets/css/fresh-bootstrap-table.css" rel="stylesheet" />
  <link href="assets/css/demo.css" rel="stylesheet" />

  <!--   Fonts and icons   -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300" rel="stylesheet" type="text/css">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table/dist/bootstrap-table.js"></script>

  <!--EXPORT-->
  <script src="tableExport/tableExport.js"></script>
  <script type="text/javascript" src="tableExport/jquery.base64.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <!--Form Style-->
  <style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
}

.form-inline label {
  margin: 5px 10px 5px 0;
}

.form-inline input, select {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}

.form-inline button {
  padding: 10px 20px;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;
}

.form-inline button:hover {
  background-color: royalblue;
}

@media (max-width: 800px) {
  .form-inline input {
    margin: 10px 0;
  }
  
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>

</head>
<body>
     <h1 style="text-align:center;"> Visitors per location </h1>
   
   <div class="btn-group pull-right" style="padding-top: 15px; padding-right: 20px;" >
    <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown"><small>Export</small></button>
    <ul class="dropdown-menu" role="menu">
      <li><a class="dataExport" data-type="excel">XLS</a></li>      
    </ul>
  </div>

  <div class="btn-group pull-left" style="padding-top:10px; padding-left: 20px;" >
    <form class="form-inline" method="POST">
      location: 
          <select name="location" >
                  <option><?php 
                    if($_SERVER["REQUEST_METHOD"]=="POST"){ 
                      if (isset($_POST['filter'])) {
                        if($_POST['location']<>'*'){
                           $sql="SELECT locdesc FROM tbl_location where locid= '$_POST[location]'";
                              $res = mysqli_query($link, $sql);
                              while ($rec = mysqli_fetch_array($res)) {
                                echo $rec['locdesc'];
                              }
                        }
                      }
                    }else{
                      echo '*';
                    }
                  ?></option>
                      <option value='*'>*</option>
                      <?php
                        $sqli = "SELECT locdesc FROM tbl_location";
                        $result = mysqli_query($link, $sqli);

                        while ($row = mysqli_fetch_array($result)) {
                          if(strcmp($location, $row['locdesc'])==0){
                            continue;
                          }
                          
                          $location= $row['locdesc'];

                         $sql = "SELECT * FROM tbl_location where locdesc='$location'";
                                $res = mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($res)) {
                                  echo '<option value="'.$row['locid']. '">'.$row['locdesc'].'</option>';
                                  
                                }
                        }
                     
                      ?>  
                </select>  

      From Date: <input type="date" name="dtfrm" id="dtfrm" value="<?php echo $dtfrm; ?>" max="<?php echo $hdate; ?>">
     
      
      <button type="submit" name="filter">Search</button>
      <button type="submit" name="clear" onClick="window.location.href=window.location.href">Clear</button>
    
    </form>
  </div>

  <div class="fresh-table full-screen-table">

    <table id="fresh-table" class="table">
      <thead>
     

        <th data-field="ctr" data-sortable="true">#</th>
        <th data-field="id" data-sortable="true">ID No</th>
        <th data-field="fullname" data-sortable="true">Fullname</th>
        <th data-field="location" data-sortable="true">Location</th>
        <th data-field="timein" data-sortable="true">Time-in</th>
        <th data-field="timeout" data-sortable="true">Time-out</th>
    
      </thead>
      <tbody>
      	<!--Get data in the Database -->
      	
        <?php
     

         $result = mysqli_query($link,"$query");
            if(mysqli_num_rows($result) > 0){
             while($row = mysqli_fetch_array($result)){
                $ctr=$ctr+1;

               $sql="SELECT locdesc FROM tbl_location where locid= '$row[location]'";
                $res = mysqli_query($link, $sql);
                while ($rec = mysqli_fetch_array($res)) {
                  $locdesc=$rec['locdesc'];

                }

      ?>

        <tr>
          <td><?php echo $ctr; ?></td>
          <td><?php echo $row["regid"]; ?></td>
          <td><?php echo $row["fullname"]; ?></td>
          <td><?php echo $locdesc; ?></td>
          <td><?php echo $row["timein"]; ?></td>
          <td><?php echo $row["timeout"]; ?></td>

        </tr>

        <?php  } 
           
        } 

        ?>

     </tbody>
    </table>
  </div>

<script>
  var $table = $('#fresh-table')

  window.operateEvents = {
  
  }

  function operateFormatter(value, row, index) {
    return [
      '<a rel="tooltip" title="Like" class="table-action like" href="" title="Like">',
        '<i class="fa fa-file"></i>',
      '</a>',
    ].join('')
  }

  $(function () {
    $table.bootstrapTable({
      classes: 'table table-hover table-striped',
      toolbar: '.toolbar',

      search: true,
      showRefresh: true,
      showToggle: true,
      showColumns: true,
      pagination: true,
      striped: true,
      sortable: true,
      height: $(window).height(),
      pageSize: 25,
      pageList: [25, 50, 100],

      formatShowingRows: function (pageFrom, pageTo, totalRows) {
        return ''
      },
      formatRecordsPerPage: function (pageNumber) {
        return pageNumber + ' rows visible'
      }
    })


    $(window).resize(function () {
      $table.bootstrapTable('resetView', {
        height: $(window).height()
      })
    })
  })


  $( document ).ready(function() {
  $(".dataExport").click(function() {
    var exportType = $(this).data('type');    
    $('#fresh-table').tableExport({
      type : exportType,      
      escape : 'false',
      ignoreColumn: []
    });   
  });
});

</script>

</body>

</html>
