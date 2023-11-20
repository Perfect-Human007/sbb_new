<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari-Packages</title>
   
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
    body{
      width:100%;
      overflow-x:hidden !important; 
      
    }
    .pop:hover{
        border-top-color: var(--navyblue_hover) !important;
        transform: scale(1.03);
        transition: all 0.3s;
    }

   </style>
    
</head>
<body class="bg-light">

   <!-- navber -->

    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
      <h2 class="fw-bold h-font text-center">Packages/Rooms</h2>
      <div class="h-line bg-dark"></div>
      
    </div>
      

    <div class="cotainer mt-4">
        <div class="row p-0">

          <?php 
            $room_res = select("SELECT * FROM `packages` WHERE `status`=? AND `removed`=?",[1,0],'ii');

            while($room_data = mysqli_fetch_assoc($room_res))
            {
                // get features
                $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f INNER JOIN `package_features` pfea ON f.id = pfea.features_id WHERE pfea.packages_id = '$room_data[id]'");
                
                $features_data = "";
                while($fea_row = mysqli_fetch_assoc($fea_q)){
                    $features_data .= "<span class='badge bg-light text-dark mb-3 text-wrap lh-base'>
                    $fea_row[name]
                    </span>";
                }

                // get facilities
                $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f INNER JOIN `package_facilities` pfac ON f.id = pfac.facilities_id WHERE pfac.packages_id = '$room_data[id]'");
                
                $facilities_data = "";
                while($fac_row = mysqli_fetch_assoc($fac_q)){
                    $facilities_data .= "<span class='badge bg-light text-dark mb-3 text-wrap lh-base'>
                    $fac_row[name]
                    </span>";
                }
                
                //get thumbnail image 

                $room_thumb = PACKAGES_IMG_PATH."thumbnail.jpg";
                $thumb_q = mysqli_query($con,"SELECT * FROM `package_images` WHERE `package_id`='$room_data[id]' AND `thumb`='1'");

                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = PACKAGES_IMG_PATH.$thumb_res['image'];

                }

                $book_btn ="";

                if(!$settings_r['shutdown']){
                  $login  = 0;
                  if(isset($_SESSION['login']) && $_SESSION['login']=true){
                      $login = 1;
                  }
                  $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white shadow-none custom-bg'>Book Now</button>";
              }


                //print room card

                echo<<<data
                    <div class="col-lg-4 col-md-6 my-3  pop">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="$room_thumb" class="card-img-top">

                            <div class="card-body">
                                <h5>$room_data[name]</h5>
                                <h6 class="mb-4">৳ $room_data[price] per month</h6>
                                <div class="features mb-1">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>

                                <div class="facilities mb-1">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>

                                <div class="rating mb-3">
                                    <h6 class="mb-1">Rating</h6>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                
                                <div class="d-flex justify-content-evenly">
                                $book_btn
                                <a href="room_details.php?id=$room_data[id]" class="btn btn-sm  btn-outline-dark shadow-none">More Details</a>
                                </div>
                            </div>
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