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
      <h2 class="fw-bold h-font text-center">Branches</h2>
      <div class="h-line bg-dark"></div>
      
    </div>
      

    <div class="cotainer mt-4">
        <div class="row p-0">

          <?php 
            $res = select("SELECT * FROM `branches` WHERE `removed`=?",[0],'i');

            while($branch_data = mysqli_fetch_assoc($res))
            {
               
              
                //get thumbnail image 

                $branch_thumb = BRANCHES_IMG_PATH."thumbnail.jpg";
                $thumb_q = mysqli_query($con,"SELECT * FROM `branch_images` WHERE `branch_id`='$branch_data[id]' AND `thumb`='1'");

                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $branch_thumb = BRANCHES_IMG_PATH.$thumb_res['image'];

                }

                //print room card

                echo<<<data
                    <div class="col-lg-4 col-md-6 my-3  pop">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="$branch_thumb" class="card-img-top">

                            <div class="card-body">
                                <h5><i class="bi bi-house"></i> $branch_data[name]</h5>
                                <h6 class="mb-4"> <i class="bi bi-geo-alt-fill"></i> $branch_data[address]</h6>
                                
                                <div class="d-flex justify-content-evenly">
                                
                                <a href="branch_details.php?id=$branch_data[id]" class="btn btn-sm  btn-outline-dark shadow-none">More Details</a>
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