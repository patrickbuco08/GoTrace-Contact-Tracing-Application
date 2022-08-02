<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Location</title>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }


    .container{
        font-family: 'Poppins', sans-serif;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #201c29;
    }
    button{
        font-family: 'Poppins', sans-serif;
        padding: 15px 30px;
        border: none;
        border-radius: 2rem;
        cursor: pointer;
        color: none;
        outline: none;
        transition: .3s ease-in-out;
    }
    button:hover{
        background:  #78679e;
        color: white;
        border-left: .8rem solid #FFFFFF;
    }
</style>
<body>
    <div class="container">
        <div class="button">
            <button onclick="getLocation()">Get Location</button>
        </div>
        <div class="modal">
            
        </div>
    </div>

    <script>
        
        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
        }
        
        function showPosition(position) {
            const radius = 0.000100;
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var latx = latitude - 14.4045599;
            var laty = longitude - 120.8649145;
            var x = Math.pow(latx, 2);
            var y = Math.pow(laty, 2);
            var sumxy = x + y;
            d = Math.sqrt(sumxy);
        
            if(d > radius){
                 alert("youre outside of your apartment");
            }else{
                 alert("youre inside of your apartment");
            }
            
        }
        
        </script>
        <!-- for whole ccat -->
        <!-- (latitude >= 14.400351 && latitude <= 14.404329) && (longitude >= 120.864905 && longitude <= 120.867316) -->
</body>
</html>