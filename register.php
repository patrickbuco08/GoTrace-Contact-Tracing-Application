<?php
	session_unset();
	if(!isset($_SESSION)){ session_start();}
	$_SESSION["campus"] = "9";
	include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>GoTrace Registration</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="gotrace.ico" />
<style>
body {
	color: #999;
	background: #f5f5f5;
	font-family: 'Roboto', sans-serif;
}
.form-control, .form-control:focus, .input-group-addon {
	border-color: #e1e1e1;
	border-radius: 0;
}
.signup-form {
	width: 90%; 
	margin: 0 auto;
	padding: 30px 0;
}
.signup-form h2 {
	color: #636363;
	margin: 0 0 15px;
	text-align: center;
}
.signup-form .lead {
	font-size: 14px;
	margin-bottom: 30px;
	text-align: center;
}
.signup-form form {		
	border-radius: 1px;
	margin-bottom: 15px;
	background: #fff;
	border: 1px solid #f3f3f3;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form .form-group {
	margin-bottom: 20px;
}
.signup-form label {
	font-weight: normal;
	font-size: 13px;
}
.signup-form .form-control {
	min-height: 38px;
	box-shadow: none !important;
	border-width: 0 0 1px 0;
}	
.signup-form .input-group-addon {
	max-width: 42px;
	text-align: center;
	background: none;
	border-bottom: 1px solid #e1e1e1;
	padding-left: 5px;
}
.signup-form .btn, .signup-form .btn:active {        
	font-size: 16px;
	font-weight: bold;
	background: #19aa8d !important;
	border-radius: 3px;
	border: none;
	min-width: 140px;
}
.signup-form .btn:hover, .signup-form .btn:focus {
	background: #179b81 !important;
}
.signup-form a {
	color: #19aa8d;
	text-decoration: none;
}	
.signup-form a:hover {
	text-decoration: underline;
}
.signup-form .fa {
	font-size: 21px;
	position: relative;
	top: 8px;
}
.signup-form .fa-paper-plane {
	font-size: 17px;
}
.signup-form .fa-check {
	color: #fff;
	left: 9px;
	top: 18px;
	font-size: 7px;
	position: absolute;
}
</style>
</head>
<body>
<div class="signup-form">	
    <form action="" method="post"> 
    	<?php
	if($_SERVER["REQUEST_METHOD"]=="POST"){	
            //$_SESSION["campus"] = "9";
	        //include_once 'config.php';
	  //check if exist
	  $sql = mysqli_query($link,"SELECT * FROM tbl_acct WHERE user='$_POST[user]' and pass=md5('$_POST[pass]')  ");
	   if(!$sql){
	  		die('Error '.mysqli_error($link));
	   }

	   $row=mysqli_fetch_array($sql);
	   if(is_array($row)){
	   		echo"<div class=\"alert alert-danger\" id=\"d\" style=\"display:block\"> Username and Password already exist! </div>
				  <script>
				  		window.setTimeout(\"closeD();\", 10000);
				  		function closeD(){
							document.getElementById(\"d\").style.display=\"none\";
						}
				  </script>
		  ";

	   }else{
			$fullname= $_POST['fn'] ." ".$_POST['mi'] .". ".$_POST['ln'];  	

	   		$sql = "INSERT INTO tbl_acct (user, pass, email, fullname, empno, position, campus, bday, sex, address, allow	)
		  			VALUES ('$_POST[user]',md5('$_POST[pass]'),'$_POST[email]', UCASE('$fullname'), '$_POST[empno]','$_POST[pos]','$_POST[campus]','$_POST[bday]','$_POST[sex]',UCASE('$_POST[address]'), '0')";

	  		if(mysqli_query($link, $sql)){
	  			    echo"	<div class=\"alert alert-success\" id=\"s\" style=\"display:block\">
					     All responses submitted successfully!
					</div>

			  <script>
			  		window.setTimeout(\"closeS();\", 10000);
			  		function closeS(){
						document.getElementById(\"s\").style.display=\"none\";
					}
			  </script>
			  ";
			} 
	   }
   
	
   }
   unset($_SESSION['campus']);
   session_destroy();
?>
		<h2>Create Account</h2>
		<p class="lead">This Registration application are require admin approval.<br> Kindly review and ensure correct information in the registration details. </p>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" class="form-control" name="user" placeholder="Username" pattern="[^'\\x22]+" title="Invalid single quote or backslash character" required="required">
			</div>
        </div>

        <div class="form-group">
			<div class="row">
				<div class="col">
				<input type="password" class="form-control" name="pass" placeholder="Password" required="required">
				<!--<input id="password" name="pass" type="password" class="form-control" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Password" required pattern="[^'\\x22]+" title="Invalid single quote or backslash character">-->
			    </div>
				<div class="col">
				<input type="password" class="form-control" name="password_two" placeholder="Confirm Password" required="required" >
				<!--<input id="password_two" name="password_two"  class="form-control" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password' : '');" placeholder="Verify Password" required pattern="[^'\\x22]+" title="Invalid single quote or backslash character">-->

				</div>	
			</div>        	
        </div>

        <div class="form-group">
			<div class="row">
				<div class="col">
				    <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
    				<input type="email" class="form-control" name="email" placeholder="Email Address" required="required" pattern="[^'\\x22]+" title="Invalid single quote or backslash character">
				</div>
            	<div class="col">
				<span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
				<input type="text" class="form-control" name="empno" placeholder="Employee Number" required="required">
				<!--<input type="text" class="form-control" name="empno" placeholder="Employee Number" required="required" pattern="[0-9]{4}[-].{3,}" title="e.g. 2020-123" pattern="[^'\\x22]+" title="Invalid single quote or backslash character">-->
		    	</div>
			</div>
        </div>
	    
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="fn" placeholder="First Name" required="required" pattern="[^'\\x22]+" title="Invalid single quote or backslash character"></div>
				<div class="col"><input type="text" class="form-control" name="mi" maxlength="2" placeholder="M.I." required="required" pattern="[^'\\x22]+" min="2" title="Invalid single quote or backslash character"></div>
				<div class="col"><input type="text" class="form-control" name="ln" placeholder="Last Name" required="required" pattern="[^'\\x22]+" title="Invalid single quote or backslash character"></div>
			</div>        	
        </div>
        
        <div class="form-group">
			<div class="row">
				<div class="col">
					<select name="pos" class="form-control" required="required" >
						<option disabled selected="">Position/Designation</option>
						<?php
							$sqli="SELECT * FROM tbl_position";
				            $result=mysqli_query($link,$sqli);
				            while($row=mysqli_fetch_array($result)){
				                if($row['posno']==1 ||$row['posno']==2){
				                    continue;
				                }
				               echo '<option value="'.$row['posno']. '">'.$row['posdesc'].'</option>';
				            }
            			?>
					</select>
				</div>
				<div class="col">
					<select name="campus" class="form-control" required="required" >
						<option disabled selected="">Branch Campus</option>
						<!--<option value="1">Bacoor Campus</option>
						<option value="2">Carmona Campus</option>
						<option value="3">Cavite City Campus</option>
						<option value="4">General Trias Campus</option>
						<option value="5">Imus Campus</option>
						<option value="6">Main Campus</option>
						<option value="7">Maragondon Campus</option>
						<option value="8">Naic Campus</option>
						<option value="9">Rosario Campus</option>
						<option value="10">Silang Campus</option>
						<option value="11">Tanza Campus</option>
						<option value="12">Trece Martires City Campus</option>-->
						<?php
							$sqli="SELECT * FROM tbl_campus";
				            $result=mysqli_query($link,$sqli);
				            while($row=mysqli_fetch_array($result)){
				               echo '<option value="'.$row['campno']. '">'.$row['campdesc'].'</option>';
				            }
            			?>

					</select>
				</div>
			</div>        	
        </div>

         <div class="form-group">
			<div class="row">
				<div class="col">
					<!--<input type="date" class="form-control" name="bday" placeholder="Birthday" required="required">-->
					Birthday
					<input type="date" title="Birthday" class="form-control" name="bday"  max="<?php echo date('Y-m-d');?>" required="required" >
				</div>
				<div class="col">
				    Sex
					<select name="sex"  class="form-control"  required="required" >
						<option disabled selected=""></option>
						<option value="M">Male</option>
						<option value="F">Female</option>
					</select>
				</div>
			</div>        	
        </div>

        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-address-book"></i></span>
				<textarea class="form-control" name="address" rows="2" placeholder="House Number/ Street/ Brgy/ Town/ Municipality "style="resize: none;" required></textarea>	

			</div>
        </div> 

		<div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="Sign Up">
        </div>
		<!--<p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>-->
    </form>
	<div class="text-center">Already have an account? <a href="login.php">Login here</a>.</div>
</div>
</body>
</html>


<?php
include_once("splash-nav.php");
?>