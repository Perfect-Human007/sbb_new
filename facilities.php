<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari-Facilities</title>
   
   <style>
    .pop:hover{
        border-top-color: var(--navyblue_hover) !important;
        transform: scale(1.03);
        transition: all 0.3s;
    }

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

   </style>
    
</head>
<body class="bg-light">

   <!-- navber -->

    <?php require('inc/header.php'); ?>

     <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Our Facilities</h2>
       <div class="h-line bg-dark"></div>
       <p class="text-center mt-3">Smart Bachelor Smart Solution</p>
     </div>

     <div class="container mt-4">
        <div class="row">

        <?php 
          $res = selectAll('facilities');
          $path = FACILITIES_IMG_PATH;
          
          while($row = mysqli_fetch_assoc($res)){
            echo<<<data
                <div class="col-lg-4 co-md-6 mb-5 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                        <div class="d-flex align-items-center mb-3">
                        <img src="$path$row[icon]" width="40px">
                        <h5 class="m-0 ms-3">$row[name]</h5>
                        </div>
                        <p>$row[description]</p>
                    </div>
                </div>
            data;
          }
        
        
        ?>


          
        </div>
     </div>


    <?php require('inc/footer.php'); ?>


 

  
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
      loop: true,
    });

    var swiper = new Swiper(".swiper-testimonial", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
       
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
      },
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