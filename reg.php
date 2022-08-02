<?php
	if(!isset($_SESSION)){ session_start();}
	$_SESSION["campus"]=$_GET["campus"];
	include_once 'config.php';
?>

<?php
	if($_SERVER["REQUEST_METHOD"]=="POST"){	

	  //check if exist
	  $sql = mysqli_query($link,"SELECT * FROM tbl_reg WHERE regid='$_POST[regid]'");
	   if(!$sql){
	  		die('Error '.mysqli_error($link));
	   }

	   $row=mysqli_fetch_array($sql);
	   if(is_array($row)){
	   		echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block;margin-top:120px;\"> ID Number already exist! </div>
				  <script>
				  		window.setTimeout(\"closeD();\", 10000);
				  		function closeD(){
							document.getElementById(\"d\").style.display=\"none\";
						}
				  </script>
		  ";

	   }else{
	   		//update counter visitor/worker
	   	  	$sqlquery = mysqli_query($link, "SELECT userctr FROM tbl_usertype WHERE userid='$_GET[usertype]' and userauto ='1' ");

	   	  	if($row=mysqli_fetch_array($sqlquery)){
	   	  		$userctr1 = $row['userctr'] +1;

	  			$sql = "UPDATE tbl_usertype SET userctr='$userctr1' WHERE userid='$_GET[usertype]'";
	  			mysqli_query($link, $sql);

	   	  	}

			
	   	  
            
			//Insert to the registration table
	   		$sql = "INSERT INTO tbl_reg (usertype, regid, fullname, age, sex, address, contactno,email, office)
		  			VALUES ('$_GET[usertype]','$_POST[regid]',UCASE('$_POST[fullname]'), '$_POST[age]','$_POST[sex]',UCASE('$_POST[address]'),'$_POST[contactno]','$_POST[email]',UCASE('$_POST[office]'))";

	  		if(mysqli_query($link, $sql)){
	  			    $_SESSION['splash'] = false;
	  			    //header("location: thankyou.php");
	  			    echo"<script> 
                        window.location='thankyou.php';
                      </script>";
	  			    
                    exit();

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

    <div class="locator" style="text-align:center">  <h6 style="text-align:center; color:#262626; font-size:11px;"> <span class="fa fa-map"></span> You're in<strong> Cavite State University-<?php 
 
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

</style>


<div class="container-xl">
	<div class="row">
		<div class="col-md-8 mx-auto">
			<div class="contact-form">
				<h1> Registration</h1>
				<form action="" method="POST">
					<div class="row">
						<div class="col-sm-6">

							<div class="form-group">
								<label for="usertype">User type <small style="color:red">*</small></label>
						<?php
                          $usertype = (isset($_GET['userdesc'])) ? $_GET['userdesc'] : '';
                          echo'<select name="usertype" id="usertype" class="form-control"  onchange="myFunction()" required/> 

                          	 <option selected>'. $usertype.'</option>';
								
								$sqli = "SELECT * FROM tbl_usertype";
				                $result = mysqli_query($link, $sqli);

				                        while ($row = mysqli_fetch_array($result)) {
				                          if(strcmp($usertype, $row['userdesc'])==0){
				                            continue;
				                          }
				                     echo '<option value="'.$row['userid']."&userdesc=".$row['userdesc'].'">'.$row['userdesc'].'</option>'; 
				                       
		                          }
		                          echo'</select>';   
				                 ?>         
	
							</div>


							<script>
		                      function myFunction(){

		                        var e = document.getElementById("usertype");
		                        var result = e.options[e.selectedIndex].value;
		                        history.replaceState(null, "", location.href.split("?")[0]); 
		                        window.location =document.location.href+ '?campus=' +<?php echo $_SESSION["campus"];?>+ '&usertype=' + result;

		                      }
		                    </script>


						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label  for="regid">ID Number <small style="color:red">*</small></label>

								

								<input type="text" name="regid" id="regid" style="background-color:white;" class="form-control" value="<?php
	if(empty( $_GET['userdesc'])==0){
		$sqli="SELECT * FROM tbl_usertype where userid='$_GET[usertype]' and userauto='1'";

                          $result=mysqli_query($link,$sqli);

                          if($row=mysqli_fetch_array($result)){
                          	$userctr= $row['userctr']+1;
                          	echo $_GET['userdesc']. $userctr;
                          	$pattern="";
                          //}elseif ($_SESSION['campus']<>'6'){
						  //		$pattern="pattern='[0-9]{4}[-].{3,}'";
						  //}else{
						  //		$pattern="";

                          }
	}							
	

?>" 

	<?php 
	  	if(empty($pattern)==0)echo $pattern;
  	?>




  required/> 
							</div>
						</div>
					</div>            
					
					<div class="form-group">	
						<label for="fullname">Fullname <small style="color:red">*</small></label>
						<input type="text" name="fullname" class="form-control" placeholder="Firstname M.I Lastname" required/> 
					</div> 

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="age">Age <small style="color:red">*</small></label>
								<input type="number" name="age" min=1 class="form-control" required/> 
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <label for="sex">Sex <small style="color:red">*</small></label>
						        <select name="sex"  class="form-control" required >
						        	<option ></option>
						        	<option value="M">Male</option>
						        	<option value="F">Female</option>
						        </select>
							</div>
						</div>
					</div>  

					<div class="form-group">
						<label for="address">Address <small style="color:red">*</small></label>
						<textarea class="form-control" name="address" rows="5" placeholder="House Number/ Street/ Brgy/ Town/ Municipality "style="resize: none;" required></textarea>	
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="contactno">Contact Number<small style="color:red">*</small></label>
								<!--<input type="tel" name="contactno"  class="form-control" pattern="[\+\6\3][0-9]{10}" minlength="13" maxlength="13" required/> -->
								<input type="tel" name="contactno"  class="form-control" pattern="[0-9]{11}" minlength="11" maxlength="11" placeholder="e.g. 09000000000" required/> 
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
						        <label for="email">Email Address <small style="color:red">*</small></label>
								<input type="email" name="email"  class="form-control" required/> 
							</div>
						</div>
					</div>  
					
					<!--New code-->
					<div class="form-group">
						<label for="office">Work Station/Office <small style="color:red">*</small></label>
						<input type="text" name="office"  class="form-control" required/> 	
					</div>
					
					
				<div class="row">
					<div class="col-sm-12">
												<div class="form-group">

					 <input type="submit" name="submit" class="btn btn-primary" value="Register" style="width:100%; background-color:#00b300;">
					 </div>
					 					 </div>

					 </div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
<?php
	include_once("splash-nav.php"); 
?>
</html>