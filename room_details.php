<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari-Room Deatils</title>
   
   <style>
    body{
      width:100%;
      overflow-x:hidden !important; 
      position: relative;
      
      
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

    <?php 
      if(!isset($_GET['id'])){
        redirect('packages.php');
      }

      $data = filteration($_GET);
      $room_res = select("SELECT * FROM `packages` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');
      if(mysqli_num_rows($room_res)==0){
        redirect('packages.php');
      }

      $room_data = mysqli_fetch_assoc($room_res);

      $book_btn ="";

      if(!$settings_r['shutdown']){
        $login  = 0;
        if(isset($_SESSION['login']) && $_SESSION['login']=true){
            $login = 1;
        }
        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white shadow-none custom-bg'>Book Now</button>";
    }

    ?>

          

      <div class="container mt-1">
          <div class="row">
            
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold h-font text-center"><?php echo $room_data['name']?></h2>
              <div class="h-line bg-dark"></div>
              <br>
              <div class="text-center" style ="font-size: 14px;">
                <a href="index.php" class="text-escondary text-decoration-none text-dark">HOME</a>
                <span class="text-escondary"> > </span>
                <a href="packages.php" class="text-escondary text-decoration-none text-dark">Packages/Rooms</a>
              </div>
            </div>

            <div class="col-lg-7 col-md-12 px-5">
              <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <?php
                                   

                    $room_img = PACKAGES_IMG_PATH."thumbnail.jpg";
                    $img_q = mysqli_query($con,"SELECT * FROM `package_images` WHERE `package_id`='$room_data[id]'");

                    if(mysqli_num_rows($img_q)>0)
                    {
                      $active_class = 'active';
                      while($img_res = mysqli_fetch_assoc($img_q)){
                        
                          echo "<div class='carousel-item $active_class '>
                              <img src='".PACKAGES_IMG_PATH.$img_res['image']."' class='d-block img-fluid w-100 rounded-3' >
                          </div>";
                          $active_class='';
                      }

                    }else{
                      echo "<div class='carousel-item active'>
                          <img src=$room_img class='d-block img-fluid w-100'>
                      </div>";
                    }
                  
                  ?>
             
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
             
            <div class="col-lg-5 col-md-12 px-4 ">
              <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body ">
                  <?php

                      echo<<<price
                          <h4>৳ $room_data[price] per night</h4>

                      price;

                      echo<<<rating
                           
                        <div class="mb-3">
                          <h6 class="mb-1">Rating</h6>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                          <i class="bi bi-star-fill text-warning"></i>
                        </div>

                      rating;


                      $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f INNER JOIN `package_features` pfea ON f.id = pfea.features_id WHERE pfea.packages_id = '$room_data[id]'");
                    
                      $features_data = "";
                      while($fea_row = mysqli_fetch_assoc($fea_q)){
                          $features_data .= "<span class='badge bg-light text-dark mb-3 text-wrap lh-base mb-1 me-1'>
                          $fea_row[name]
                          </span>";
                      }

                      echo<<<features
                        <div class="features mb-3"
                          <h6 class="mb-1">Features: </h6>
                          $features_data
                        </div>
                      features;

                      $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f INNER JOIN `package_facilities` pfac ON f.id = pfac.facilities_id WHERE pfac.packages_id = '$room_data[id]'");
                    
                      $facilities_data = "";
                      while($fac_row = mysqli_fetch_assoc($fac_q)){
                          $facilities_data .= "<span class='badge bg-light text-dark mb-3 text-wrap lh-base mb-1 me-1'>
                          $fac_row[name]
                          </span>";
                      }

                      echo<<<facilities
                        <div class="facilities mb-1">
                            <h6 class="mb-1">Facilities:</h6>
                            $facilities_data
                        </div>

                      facilities;

                  

                      echo<<<book
                         $book_btn

                      book;

                  ?>
                    <div class="col-12 mt-4 px-2">
                          <div class ="mb-4">
                            <h5> Description </h5>
                            <p>
                              <?php 
                                echo $room_data['description']
                              ?>
                            </p>
                        </div>
                    </div>
                  
             
                </div>
              </div>
            </div>
           
            <div class="mt-5 px-5">
              <h5 class="mb-3 ">Review & Rating</h5>
              <div class="profile d-flex align-items-center mb-2">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-1</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus sed dolor deserunt id perferendis itaque consequuntur nam illum temporibus eius.
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
            </div>
           

              


              
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