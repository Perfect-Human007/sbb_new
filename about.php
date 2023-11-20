<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari-About</title>
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
   
    <style>
        /* width */
        ::-webkit-scrollbar {
        width: 15px;
        }
        
        /* Track */
        ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey; 
        border-radius: 10px;
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #FFC300 ; 
        border-radius: 10px;
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #b30000; 
        }
      .box{
        border-top-color: var(--navyblue_hover) !important;
      }
    </style>
    
</head>
<body class="bg-light">

   <!-- navber -->

    <?php require('inc/header.php'); ?>

     <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">About Us</h2>
       <div class="h-line bg-dark"></div>
       
     </div>

     <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <?php
                     $about_q = selectAll('settings');

                     while($row = mysqli_fetch_assoc($about_q)){
                        echo<<<data
                            <h3 class="mb-3">$row[site_title]</h3>
                              <p>$row[site_about]</p>
                        data;

                        
                     }
                
                ?>
            
            
            </div>

            <div class="col-lg-5 col-md-5 mb-4 order-1">
                <img src="img/packages/2.1a.jpg  " class="w-100 shadow rounded">

            </div>
        </div>
     </div>

     <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-3 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="img/about/hostel.svg" width="70px">
                <h4 class="mt-3">50+ rooms</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="img/about/people.svg" width="70px">
                <h4 class="mt-3">70+ Customers</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="img/about/rating.svg" width="70px">
                <h4 class="mt-3">150+ Reviews</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="img/about/staff.svg" width="70px">
                <h4 class="mt-3">50+ staff</h4>
                </div>
            </div>
        </div>

     </div>

     <h3 class="mt-5 fw-bold h-font text-center">Manegement Teams</h3>
      
     <div class="container mt-5 px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">

            <?php 
                $about_r = selectAll('team_details');
                $path = ABOUT_IMG_PATH;

                while($row = mysqli_fetch_assoc($about_r)){
                    echo<<<data
                        <div class="swiper-slide text-center rounded">
                            <img src="$path$row[picture]" class="w-100">
                            <h5 class="mt-5">$row[name]</h5>
                        </div>
                    data;
                }
            
            ?>
                
            </div>
            <div class="swiper-pagination"></div>
        </div>

     </div>

    <?php require('inc/footer.php'); ?>


      <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 40,

        pagination: {
        el: ".swiper-pagination",
        },
        breakpoints: {
        320: {
            slidesPerView: 1,
        },
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }, 
      },
    });
    </script>

 
</body>
</html>