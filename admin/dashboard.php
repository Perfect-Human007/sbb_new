<?php
  
  require('inc/essential.php');
  adminLogin();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal - dashborad</title>

    <?php require('inc/links.php');?>

    <style> 
      #div1 {
        background-color: #FF5733;
        position: relative;
        animation-name: example;
        animation-duration: 4s;
      }

      @keyframes example {
        0%   {background-color:#FF5733; left:0px; top:0px;}
        25%  {background-color:yellow; left:200px; top:0px;}
        50%  {background-color:blue; left:200px; top:200px;}
        75%  {background-color:green; left:0px; top:200px;}
        100% {background-color:#FF5733; left:0px; top:0px;}
      }
</style>
</head>
<body class="bg-light">
    
<?php
  
  require('inc/header.php');
  

?>


    <div class="container-fluid " id="main-contant">
      <div class="row">
        <div id="div1"class="col-lg-10 ms-auto p-4 overflow-hidden rounded">
             <h1 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Welcome to Smart Bachelor Bari<br> Admin</h1>
        </div>
      </div>
    </div>


      <?php require('inc/scripts.php'); ?>
</body>
</html>