<?php 
error_reporting(E_ALL & ~E_NOTICE);

 ?>
<link rel="shortcut icon" href="gotrace.ico" type="image/x-icon" />

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
#Splash {
	 position: fixed; /* Sit on top of the page content */
height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
      
  background: background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(19,134,40,1) 0%, rgba(137,205,76,1) 100%); 
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}
@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
    }
}


.splashimg{
 	 display: block;
 	 margin: auto;
 	 	margin-top:20%;

 	 	width:85%;

}
.locator{
    display: flex;
    height:20px;
    width:100%; 
    background:
    margin-left:0px;
    margin-top:11px;

}
@media (min-width: 375px) {
  .splashimg {
  	 	 	margin-top:40%;
 	width:80%;

		    }
  
}
@media (min-width: 576px) {
  .splashimg {
  	 	 	margin-top:20%;

 	width:65%;
 		padding:12%;

		    }
}

@media (min-width: 768px) {
 .splashimg {
 	 	 	margin-top:0%;

 	width:45%;
	padding:12%;


  }

  @media (min-width: 812px) {
 .splashimg {
 	 	 	margin-top:0%;

 	width:35%;
	padding:8%;

    }
  }

* {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
        }

        .navbar {
            font-size: 18px;
background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(19,134,40,1) 0%, rgba(137,205,76,1) 100%);            padding-bottom: 10px;
        }

        .logo {
        	 display: block;
 	 margin: auto;
            display: inline-block;
            margin-top: 5px;
            margin-left: 15px;
        }

@media (min-width: 375px) {

        .navbar {max-height:20px;}

}
        @media screen and (min-width: 768px) {

            .logo {
            	        	 display: block;
                margin-top: 0;
            }
                    .navbar {max-height:100px;}


        }


</style>


<nav class="navbar" style="background: background: rgb(2,0,36);
background: linear-gradient(-80deg, rgba(2,0,36,1) 0%, rgba(19,134,40,1) 0%, rgba(137,205,76,1) 100%); 	display: flex; top:0; position: fixed;
width: 100%;">
<a href="https://gotrace.cvsuccatre.com" class="logo"><img src="WiTR-rectangle-2.png" style="height:64px" /></a> 

    <!--  <div class="locator" style="text-align:center">  <h6 style="text-align:center; color:#262626; font-size:11px;"> <span class="fa fa-map"></span> You're in<strong> Cavite State Univeristy </strong> </h6> </div> -->
</nav> 
  

 <foot> 
<div style=" position: fixed; left:0;  bottom: 0;  width: 100%; font-size:10px; color:gray; text-align:center; background-color:white;">
<p > Copyright 2020. All rights reserved. <a href="https://reserviceportal.cvsuccatre.com" style="color:gray;">Cavite State University-CCAT Research and Extension Unit.</a> <a href="https://gotrace.cvsuccatre.com/data-privacy.html" style="color:gray;">Data Privacy. Terms and Conditions.</a></p>    
</div>
</foot>
