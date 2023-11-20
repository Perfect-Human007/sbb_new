<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/common.css">

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <?php

    session_start();
    date_default_timezone_set('Asia/Dhaka');
    require('admin/inc/db_config.php');
    require('admin/inc/essential.php');

 
   
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values =[1];
    $settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));

    if($settings_r['shutdown']){
        echo<<<alertbar
           <div class='bg-danger text-center p-2 fw-bold fixed-top'>
             <i class="bi bi-exclamation-triangle-fill"></i>
             Bookings are temporarily closed!
           </div>

        alertbar;
    }
    
    ?>