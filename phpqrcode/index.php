<?php  
require_once "..\config.php";   
if(!isset($_SESSION)){ session_start();}

/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
    
    echo "<h1>Location QR Code Generator</h1><hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        //echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
    //config form
    //<option value="http://gotrace.000webhostapp.com/reg.php?campus='. $_SESSION["campus"] .'">Registration</option>

      

    echo '<form action="index.php" method="post">
        Type:&nbsp;<select onchange="myFunction(this.value)">
              <option value="reg.php?campus='. $_SESSION["campus"] .'">Registration</option>
              <option value="healthsurvey.php?campus='. $_SESSION["campus"] .'">Health Survey</option>
              <option value="area">Area in/out</option>
              </select>

        <script>
          function myFunction(x) {
            if(x=="area"){
               document.getElementById("divloc").style.display = "block";     
            }else{
               document.getElementById("divloc").style.display = "none";   
               document.getElementById("data").value =  x;
            }
            
          }
        </script>      

        <script>
          function myFunction1(x) {
            document.getElementById("data").value =  x;
          }
        </script> 

        <div style="display:none" id="divloc">
        Location:&nbsp;<select name="locid" onchange="myFunction1(this.value)" >

             <option selected><?php echo $locid; ?></option>
        ';
            $sqli="SELECT * FROM tbl_location";
            $result=mysqli_query($link,$sqli);

            while($row=mysqli_fetch_array($result)){
                if(strcmp($locid, $row['locid'])==0){
                    continue;
                }

                $locid= $row['locid'];

                $sql="SELECT * from tbl_location where locid='$locid'";
                    $res=mysqli_query($link,$sql);
                    while($row=mysqli_fetch_array($res)){
                        echo '<option value="contrace.php?campus='.$_SESSION["campus"].'&id='.$row['locid']. '">'.$row['locdesc'].'</option>';
                    }
               //echo '<option value="contrace.php?campus='.$_SESSION["campus"].'&id='.$row['locid']. '">'.$row['locdesc'].'</option>';
               
            }
            
    
    echo'</select> </div>
        Data:&nbsp;<input name="data" id="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
        ECC:&nbsp;<select name="level">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
        </select>&nbsp;
        Size:&nbsp;<select name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
    //QRtools::timeBenchmark();    

    