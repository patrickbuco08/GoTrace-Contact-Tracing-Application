
<?php
	if(!isset($_SESSION)){ session_start();}
	$_SESSION["campus"]=$_GET["campus"];

	if (isset($_GET["id"])){
		$loc=$_GET["id"];		
	}else{
		$loc=1;		
	}
	
	include_once 'config.php';
	include_once 'starscript.php';

   
    /*if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
		$loc= $_GET['id']; 
	}else{
		$loc= 1; 
	}*/

	date_default_timezone_set('Asia/Manila');
    $today = strtotime(date("y-m-d h:i:sa"));
    $hdate= date("Y-m-d", $today);

?>

<?php
   $fn=$regid='';
    $show=0;
	if($_SERVER["REQUEST_METHOD"]=="POST"){	

		if (isset($_POST['btnsearch'])) {
			$sql = mysqli_query($link,"SELECT * FROM tbl_reg WHERE regid='$_POST[regid]'");
			if(!$sql){
			   die('Error '.mysqli_error($link));
			} 

			$row=mysqli_fetch_array($sql);
	   			if(is_array($row)){
	   				
	   				$sql1 = mysqli_query($link,"SELECT * FROM tbl_healthsurvey WHERE regid='$_POST[regid]' and hdate ='$hdate'");
					if(!$sql1){
					   die('Error '.mysqli_error($link));
					} 

					$row1=mysqli_fetch_array($sql1);
		   			if(is_array($row1)){
		   				echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block; margin-top:120px;\">Health Survey Form already Exist!</div>
								  <script>
								  		window.setTimeout(\"closeD();\", 10000);
								  		function closeD(){
											document.getElementById(\"d\").style.display=\"none\";
										}
								  </script>
						  ";
						 $regid='';
		   				 $fn='';
		   				 $dose='';
		   				 $vaccine='';
		   				 $show=0;
		   			}else{
		   				$regid=$_POST['regid'];
		   				$fn=$row['fullname'];
		   				$dose= isset($row['dosage']) ? $row['dosage'] : '';   //dosage
		   				$vaccine=isset($row['vactype']) ? $row['vactype'] : '';   //vaccine type
		   				$show=1;		

		   				
							  $showfeedback=0;
			                  $rec = mysqli_query($link, "SELECT * FROM tbl_evaluation WHERE regid='$_POST[regid]'");
			                 
			                  if(mysqli_num_rows($rec) == 0){
			                  	$showfeedback=1;
			                  }


		   			}	   				
		   									
	   			}else{
	   				$regid='';
	   				$fn='';
	   				$dose='';
	   				$vaccine='';
	   				$show=0;

	   				echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block; margin-top:120px;\"> Your profile doesn't exist!, Please  <a href='http://gotrace.cvsuccatre.com/reg.php?campus=".$_SESSION["campus"]."'>register here.</a></div>
							  <script>
							  		window.setTimeout(\"closeD();\", 20000);
							  		function closeD(){
										document.getElementById(\"d\").style.display=\"none\";
									}
							  </script>
					  ";
	   			}
		}

		if (isset($_POST['submit'])) {
			$regid = $_POST['regid'];
			//$hdate
			$temp = $_POST['temp'];
			$origin = $_POST['origin'];
			$cough = $_POST['cough'];
			$sore = $_POST['sore'];
			$breathing = $_POST['breathing'];
			$diarrhea = $_POST['diarrhea'];
			$bodypains = $_POST['bodypains'];
			$closeprox = $_POST['closeprox'];
			$travelled = $_POST['travelled'];
			$agree = $_POST['agree'];
			$dosage = $_POST['dose'];
			$vaccinetype = $_POST['vaccine'];
			
			if($_POST['like']<>0){
				mysqli_query($link, "INSERT INTO tbl_evaluation VALUES (UCASE('$regid'), '$hdate', '$_POST[like]', '$_POST[feedback]')");
			}


			$sql = "INSERT INTO tbl_healthsurvey (regid, hdate, temp, origin, cough, sore, breathing, diarrhea, bodypains, closeprox, travelled, agree) VALUES (UCASE('$regid'),'$hdate','$temp',UCASE('$origin'),'$cough','$sore','$breathing','$diarrhea','$bodypains','$closeprox','$travelled','$agree')";



		  		if(mysqli_query($link, $sql)){


		  			//auto save in
		  			
				    $gettime= date("H:i:s", $today);

		  			$timeout='00:00:00';
		  			//if($loc=='2'){$loc='1';}
		  			//$sql3 = "INSERT INTO tbl_contracing (regid,	hdate,	timein, timeout, location)
					//			VALUES (UCASE('$_POST[regid]'),'$hdate','$gettime','$timeout','$loc')";

			  		$sql3 = "INSERT INTO tbl_contracing (regid,	hdate,	timein, timeout, location)
								VALUES (UCASE('$regid'),'$hdate','$gettime','$timeout','$loc')";

					if(mysqli_query($link, $sql3)){

						mysqli_query($link, "UPDATE tbl_reg SET dosage='$dosage', vactype='$vaccinetype' WHERE regid='$regid' ");

						if (($temp >= 37.5) OR ($temp >= 37.5 AND cough == 1) OR ($temp >= 37.5 AND $sore == 1) OR ($temp >= 37.5 AND $breathing = 1) OR ($temp >= 37.5 AND $diarrhea == 1) OR ($cough == 1 AND $sore == 1) OR ($cough == 1 AND $breathing == 1) OR ($cough == 1 AND $diarrhea == 1) OR ($cough == 1 AND $pains == 1) OR ($sore == 1 AND $breathing == 1) OR ($sore == 1 AND $diarrhea == 1) OR ($breathing == 1 AND $diarrhea == 1) OR ($diarrhea == 1)){
							echo"<script> 
                            window.location='warning.php';
						  </script>";
						  $_SESSION["regid"]= $regid;
						  exit();
						}else{
							echo"<script> 
                            window.location='thankyou.php';
						  </script>";
						  $_SESSION["regid"]= $regid;
						  exit();		
						}

						//Update the employee vaccine record

		  			}
					/*echo"	<div class=\"alert alert-success\" id=\"s\" style=\"display:block\">
						     All responses submitted successfully!
						</div>

				  <script>
				  		window.setTimeout(\"closeS();\", 10000);
				  		function closeS(){
							document.getElementById(\"s\").style.display=\"none\";
						}
				  </script>
				  ";*/
				}
		}
	 
	} 

?>

<nav class="navbar" style="background: background: rgb(2,0,36);
background: linear-gradient(-80deg, rgba(2,0,36,1) 0%, rgba(19,134,40,1) 0%, rgba(137,205,76,1) 100%); 	display: flex; top:0; position: fixed;
width: 100%;">
<a href="https://gotrace.cvsuccatre.com" class="logo"><img src="WiTR-rectangle-2.png" style="height:64px" /></a> 

    <div class="locator" style="text-align:center">  <h6 style="text-align:center; color:#262626; font-size:11px;"> <span class="fa fa-map"></span> You're in <strong> Cavite State University-<?php 
 
               include_once 'config1.php';
                $result = mysqli_query($link1,"SELECT * FROM tbl_campus WHERE campno = '$_SESSION[campus]'");
                $row = mysqli_fetch_array($result);   

                echo $row['campdesc'];

    ?>





    </strong> </h6> </div> 
</nav>


<?php 
include_once("header.php"); 
?>

<style>
body {
    color: #566787;
    background: #f5f5f5;
    font-family: "Open Sans", sans-serif;
}
.contact-form {
    padding: 50px;
    margin: 30px 0;
}
.contact-form h1 {
    text-transform: uppercase;
    margin: 0 0 15px;
}
.contact-form .form-control, .contact-form .btn  {
    min-height: 38px;
    border-radius: 2px;
}
.contact-form .btn-primary {
    min-width: 150px;
    background: #299be4;
    border: none;
}
.contact-form .btn-primary:hover {
    background: #1c8cd7; 
}
.contact-form label {
    opacity: 0.9;
}
.contact-form textarea {
    resize: vertical;
}
.hint-text {
    font-size: 15px;
    padding-bottom: 15px;
    opacity: 0.8;
}
.bs-example {
    margin: 20px;
}

/*For Modal*/
.modal {
}
.vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 100%;
}
.vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: middle;
}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
    width:inherit;
    height:inherit;
    /* To center horizontally */
    margin: 0 auto;
}

</style>
  <link rel="shortcut icon" href="gotrace.ico" />
</head>

<div class="container-xl">
	<div class="row">
		<div class="col-md-8 mx-auto">
			<div class="contact-form">
				<h1>Health Survey</h1>
				<form action="" method="POST">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label  for="regid">ID Number </label>
								<input type="text" name="regid" value="<?php echo $regid;?>" class="form-control"  placeholder="Employee ID/Student ID/Visitor or Worker ID" style="width:100%" />
							</div>
						</div>
					</div>            
					
					<div class="form-group" <?php if($show==1){echo"style='display: none;'";} ?>>	
						<input type="submit" name="btnsearch" id="btnsearch" class="btn btn-primary" value="Search" style="width:100%; background-color:green;" >

						 <!-- <button type="button"   name="btnsearch" id="btnsearch" class="btn btn-primary" data-toggle="modal" data-target="#Feedback" style="width:100%; background-color:green;">
		                    Search
		                  </button>-->

					</div>



					<div class="modal fade" id="Feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <!--<div class="modal-dialog" role="document">-->
						   <div class="vertical-alignment-helper">
       						<div class="modal-dialog vertical-align-center">	    
						    <div class="modal-content">
						      <div class="modal-header">
						        <h6 class="modal-title" id="exampleModalLabel">How's your GoTrace experience?</h6>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	<div class="row">
						                 Rate and Review<br><br>
						                  <div class="col-md-12">
						                    <!--<input type="text" name="locdesc" class="form-control form-control-sm" placeholder="Type location description" name="locdesc" value="<?php//echo $regid;?>"> -->
						                    
						                    <h2>
						                    	<section id="like" class="rating">
												  <!-- FIFTH HEART -->
												  <input type="radio" id="heart_5" name="like" value="5" />
												  <label for="heart_5" title="Five">&#9733;</label>
												  <!-- FOURTH HEART -->
												  <input type="radio" id="heart_4" name="like" value="4" />
												  <label for="heart_4" title="Four">&#9733;</label>
												  <!-- THIRD HEART -->
												  <input type="radio" id="heart_3" name="like" value="3" />
												  <label for="heart_3" title="Three">&#9733;</label>
												  <!-- SECOND HEART -->
												  <input type="radio" id="heart_2" name="like" value="2" />
												  <label for="heart_2" title="Two">&#9733;</label>
												  <!-- FIRST HEART -->
												  <input type="radio" id="heart_1" name="like" value="1" />
												  <label for="heart_1" title="One">&#9733;</label>
												</section>
											</h2>
											<br>
										  </div>
										  <div class="row">
										  <div class="col-md-12">
												  <textarea class="form-control" name="feedback" cols="100" rows="4" placeholder="Describe your experience (optional)" style="resize: none;"></textarea>  
						                  </div>
						              </div>
						               
						           
						      </div>
</div>
</div>
<!--</div> -->



						    </div>
						  </div>
					</div>					 


		<div id="survey_form" <?php if($show==0){echo"style='display: none;'";}else {echo"style='display: block';";} ?>>


				<!--<div class="row">
					<div class="col-sm-6">-->
						<div class="form-group">
							<label for="fullname">Fullname</label>
							<input type="text" name="fullname" value="<?php echo $fn;?>" class="form-control"  readonly />
						</div>
					<!--</div>
				</div>-->
				<div class="row">
						<div class="col-sm-9">
							<div class="form-group">
								<label for="dose"> Have you received any dosage of COVID-19 vaccines?	<small style="color:red">*</small></label>
								<select name="dose" class="form-control" <?php if($show==1){echo"required";}else{echo"";}?>>
									<option value="" <?php if ($dose=="" ) echo "selected"; ?>></option>
									<option value="3" <?php if ($dose=="3" ) echo "selected"; ?>>Fully vaccinated?</option>
									<option value="1" <?php if ($dose=="1" ) echo "selected"; ?>>First dose?</option>
									<option value="0" <?php if ($dose=="0" ) echo "selected"; ?>>None at all</option>
								</select>	
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								
								<label for="vaccine">Vaccine Type<small style="color:red">*</small></label>

								<select name="vaccine" class="form-control" <?php if($show==1){echo"required";}else{echo"";}?>>
									<option value="" <?php if ($vaccine=="" ) echo "selected"; ?> ></option>
									<option value="None at all" <?php if ($dose=="0" ) echo "selected"; ?>>None at all</option>
									<option value="AztraZeneca" <?php if ($vaccine=="AztraZeneca" ) echo "selected"; ?> >AztraZeneca</option>
									<option value="Jannsenn" <?php if ($vaccine=="Jannsenn" ) echo "selected"; ?> >Jannsenn</option>
									<option value="Moderna" <?php if ($vaccine=="Moderna" ) echo "selected"; ?>>Moderna</option>
									<option value="Novavax" <?php if ($vaccine=="Novavax" ) echo "selected"; ?>>Novavax</option>
									<option value="Pfizer BioNTech" <?php if ($vaccine=="Pfizer BioNTech" ) echo "selected"; ?>>Pfizer BioNTech</option>
									<option value="Sputnik V" <?php if ($vaccine=="Sputnik V" ) echo "selected"; ?>>Sputnik V</option>
									<option value="Sinovac" <?php if ($vaccine=="Sinovac" ) echo "selected"; ?>>Sinovac</option>
									<option value="Sinopharm" <?php if ($vaccine=="Sinopharm" ) echo "selected"; ?>>Sinopharm</option>
								</select>
							</div>
						</div>
			    </div>



					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
									<script>
										function validateFloatKeyPress(num) {
										var v = parseFloat(num.value);
										num.value = (isNaN(v)) ? '' : v.toFixed(2);
										}
									</script>

								<label for="temp">Body Temperature <small style="color:red">*</small></label>
								<input type="num" name="temp" class="form-control" min='1' max='37' onchange="validateFloatKeyPress(this);" onfocusout="document.getElementById('origin').focus();" <?php if($show==1){echo"required";}else{echo"";}?>/>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <label for="origin">Origin <small style="color:red">*</small></label>
								<input type="text"  name="origin" id="origin" class="form-control" <?php if($show==1){echo"required";}else{echo"";}?>/>
							</div>
						</div>
					</div>  	


					<div class="form-group">	
						<label for="question1">1. Are you currently experiencing any of the following symptoms?
							<br><small> (Nakararanas ka ba ng kasalukuyan ng:)</small></label>
					</div> 

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="cough">a.  Cough <small> (Ubo)</small></label>
								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <input type="radio" name="cough" value="1" >
								<label for="yes">Yes         </label>
								<input type="radio" name="cough" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
						</div>
					</div>  


					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="sore">b.  Sore Throat <small> (Pananakit ng lalamunan)</small></label>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <input type="radio" name="sore" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="sore" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
						</div>
					</div>  

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="breathing">c.  Difficulty of Breathing <small> (Hirap sa paghinga)</small></label>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <input type="radio" name="breathing" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="breathing" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
						</div>
					</div>  

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="diarrhea">d.  Diarrhea <small> (Pagtatae)</small></label>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <input type="radio" name="diarrhea" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="diarrhea" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
						</div>
					</div>  


					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="bodypains">e.  Body Pains <small> (Pananakit ng katawan)</small></label>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <input type="radio" name="bodypains" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="bodypains" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
						</div>
					</div>  
					
					<div class="form-group">	
						<label for="question2">2. Have you been in close proximity with a confirmed COVID-19 case for the past 14 days?
							<br><small> (May nakasama ka ba na taong positibo sa COVID-19 sa nakaraang 14 na araw?)</small></label>
						
							<div class="form-group">
						        <input type="radio" name="closeprox" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="closeprox" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
					</div>

					<div class="form-group">	
						<label for="question3 ">3. Have you travelled outside Cavite for the past 14 days?
							<br><small> (Ikaw ba ay nagpunta/nagbyahe sa labas ng Cavite sa nakalipas na 14 na araw?)</small></label>
						
							<div class="form-group">
						        <input type="radio" name="travelled" value="1">
								<label for="yes">Yes         </label>
								<input type="radio" name="travelled" value="0" <?php if($show==1){echo"required";}else{echo"";}?> >
								<label for="no">No</label>
							</div>
					</div>

					<div class="form-group">
						<label for="confirm" style="text-align: justify;">
						<input type="checkbox" name="agree" data-toggle="modal" 
							<?php if($showfeedback==1){
								echo'data-target="#Feedback"';
							}
							?>
						    onclick="functionagree(this)" value="1" <?php if($show==1){echo"required";}else{echo"";}?>>	
							 I hereby reaffirm, and give my consent to Cavite State University, to collect, store, use, analyze and/or process my personal information for such purposes as may be needed by the University to ensure a safe and healthy work environment for all.
						</label>

						<script>
							function functionagree(chkagree){
								if(chkagree.checked){
									document.getElementById("submit_button").disabled = false;
							    } else{
							        document.getElementById("submit_button").disabled = true;
							    }
							}
						</script>

						
					</div>
					 <input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Submit"  style="width:45%; padding-left:4%; background-color:green;" />

					 <button class="btn btn-danger" style="width:45%; color:white; padding-left:4%;" ><a style="color:white;" href="healthsurvey.php?campus=<?php echo $_GET['campus']; ?>">Cancel</a></button> 

	</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
    include_once("splash-nav.php"); 
?>
</body>
</html>
