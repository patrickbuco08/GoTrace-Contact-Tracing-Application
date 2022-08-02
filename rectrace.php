<?php
 require_once "config.php";   
     if(!isset($_SESSION)){ session_start();}
      $ctr=0;
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

</head>
<body>
     <h1 style="text-align:center;"> Tracing Record </h1>

  <div class="btn-group pull-right" style="padding-top: 12px">
    <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown"><small>Export</small></button>
    <ul class="dropdown-menu" role="menu">
      <li><a class="dataExport" data-type="excel">XLS</a></li>          
    </ul>
  </div>

  <div class="fresh-table full-screen-table">

    <table id="fresh-table" class="table">
      <thead>
        <th data-field="ctr" data-sortable="true">#</th>
        <th data-field="id" data-sortable="true">ID No</th>
        <th data-field="fn" data-sortable="true">Fullname</th>
        <th data-field="ref" data-sortable="true">Date</th>
        <th data-field="tdatetime" data-sortable="true">Time-in</th>
        <th data-field="clientname" data-sortable="true">Time-out</th>
        <th data-field="attendant" data-sortable="true">Location</th>
       <!-- <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Actions</th>-->
      </thead>
      <tbody>
      	<!--Get data in the Database -->
      	<?php
	       $result = mysqli_query($link,"SELECT * FROM tbl_contracing");
	          if(mysqli_num_rows($result) > 0){
	           while($row = mysqli_fetch_array($result)){
              $ctr=$ctr+1;
	        ?>

        <tr>
          <td><?php echo $ctr; ?></td>
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
          <td><?php echo $row["hdate"]; ?></td>
          <td><?php echo $row["timein"]; ?></td>
          <td><?php echo $row["timeout"]; ?></td>

          <td>
          	<?php
          	 $result1 = mysqli_query($link,"SELECT locdesc FROM tbl_location WHERE locid='$row[location]' ");
        			  $row1 = mysqli_fetch_array($result1);
        			  if(is_array($row1)) {
        			      echo $row1["locdesc"]; 
        			  } 
	          ?>
          </td>
          <!--<td></td>-->
        </tr>

        <?php  } 
        } 
        mysqli_close($link);
        ?>

     </tbody>
    </table>
  </div>

<script>
  var $table = $('#fresh-table')

  window.operateEvents = {
    /*'click .like': function (e, value, row, index) {
      alert('You click like icon, row: ' + JSON.stringify(row))
      console.log(value, row, index)
    },
    'click .edit': function (e, value, row, index) {
      alert('You click edit icon, row: ' + JSON.stringify(row))
      console.log(value, row, index)
    },
    'click .remove': function (e, value, row, index) {
      $table.bootstrapTable('remove', {
        field: 'id',
        values: [row.id]
      })
    }*/
  }

  function operateFormatter(value, row, index) {
    return [
      '<a rel="tooltip" title="Like" class="table-action like" href="" title="Like">',
        '<i class="fa fa-file"></i>',
      '</a>',
      /*'<a rel="tooltip" title="Edit" class="table-action edit" href="javascript:void(0)" title="Edit">',
        '<i class="fa fa-edit"></i>',
      '</a>',
      '<a rel="tooltip" title="Remove" class="table-action remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
      '</a>'*/
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