<?php
 require_once "config.php";   
 if(!isset($_SESSION)){ session_start();}
              $_SESSION['splash'] = false;

   include_once("nav.php"); 

include_once("header.php"); 

?>
<style type="text/css">
body {
    color: #566787;
    background: #f5f5f5;
    font-family: "Open Sans", sans-serif;
}
h1{
	color:##182f93;
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



@media (min-height: 568px) {
  .h-md-100 {height: 36vh; top:0;}
  .mb-0 { font-size: 28px; font-weight: bold; }
    .mb-4{ font-size: 14px; }
.thiss { margin-left: 0%; padding-left:0px; margin-top:0;}
.h1{ font-size:30px;}
.h5{ font-size:10px;}

   .img-fluid{

 max-width: 99%;  height: auto;   margin-top:45%;
  }
}



@media (min-height: 667px) {
  .h-md-100 {height: 36vh; top:0;}
  .mb-0 { font-size: 28px; font-weight: bold; }
    .mb-4{ font-size: 14px; }
.thiss { margin-left: 0%; padding-left:0px; margin-top:0;}
.h1{ font-size:40px;}
.h5{ font-size:14px;}
   .img-fluid{

 max-width: 99%;  height: auto;   margin-top:35%;
  }
}


@media (min-width: 768px) {
  .h-md-100 {height: 74vh;}
    .mb-0 { font-size: 46px; font-weight: bold; }
.thiss {padding:10%; margin-left: 15%; }
.h1{ font-size:46px;}
.h5{ font-size:14px;}
  .img-fluid{
 
 max-width: 80%;  height: auto; margin-top:18%;
  }
}

@media (min-width: 812) {
  .h-md-100 {height: 36vh; top:0;}
  .mb-0 { font-size: 28px; font-weight: bold; }
    .mb-4{ font-size: 14px; }
.thiss { margin-left: 0%; padding-left:0px; margin-top:0;}

   .img-fluid{

 max-width: 99%;  height: auto;   margin-top:20%;
  }
}

.btn-round { border-radius: 30px;}
.bg-indigo {background: white;}
.text-cyan { color: #35bdff;}



/* Style the image inside the centered container, if needed */

</style>
<?php
    include_once("nav.php");
?>

<body style="background:white;">
<!-- Main -->
<div class="d-md-flex h-md-100 align-items-center" style="padding-top:160px; ">
		<div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
							<div style="color:black; text-align: left;  " class='thiss'>
				<h2 class="mb-0 mt-3 display-4" style="color:red"> <b>Please contact your health representative</b></h2><br>
				<h5 class="mb-4 font-weight-light" >Your response have been recorded. Please contact your nurse/doctor immediately. Always remember to wear mask, sanitize, and scan! Take care.
</h5>
				</a>
				</div>
		</div>
	<div class="col-md-6 p-0 h-md-100 loginarea" >
		<div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
					<img src='consultation.png'  class="img-fluid" alt="Responsive image" >
		</div>
	</div>
</div>
<!-- End Main -->

