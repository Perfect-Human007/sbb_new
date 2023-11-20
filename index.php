<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari</title>
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
   

    <style>
        body{
        width:100%;
        overflow-x:hidden !important; 
        
        }
      .check-and-book{
        margin-top: -50px;
        z-index: 2;
        position: relative;
        }

        @media screen and (max-width: 575px) {
            .check-and-book{
                margin-top: 25px;
               padding: 0 35px;
                }
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

        #facAnimation{
        width: 150px;
        height: 170px;
        background: red;
        transition: width 1s, height 1s, transform 1s;
        }
        #facAnimation:hover{
        width: 300px;
        height: 300px;
        transform: rotate(360deg);
        }
    </style>
   

</head>
<body class="bg-light">
       
            
            


   <!-- navber -->

    <?php require('inc/header.php'); ?>

     <!-- Carousel -->
     
    <div class="container-fluid px-lg-2 mt-3">   
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                   
                   $res = selectAll('carousel');
                
                   while($row = mysqli_fetch_assoc($res)){
                    $path = CAROUSEL_IMG_PATH;
                     echo <<<data
                     
                      
                            <div class="swiper-slide">
                                <img src="$path$row[image]" class="w-100 d-block"/>
                            </div>
                     data;
                   }
                ?>
            
                
            </div>
        </div>
    </div>

    <!-- Check and Book -->
  

    <div class="container check-and-book">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded d-flex justify-content-evenly">
                <h4 class="h-font">Check <span class="fw-bold">Packages</span> and <span class="fw-bold">Book Now</span> </h4>
                <div class="row">
                    
                    
                        <?php
                            

                            if(!$settings_r['shutdown']){
                               echo<<<data
                                  <a href='packages.php' class='btn btn-sm text-white shadow-none custom-bg'>Book Now</a>
                               data;
                            }
                        ?>
                        <a href="packages.php" class="btn btn-sm  btn-outline-dark shadow-none mt-2 p-2 fs-6">Packages</a>
                    
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Packages -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Packages/Rooms</h2>

    <div class="cotainer mt-4">
        <div class="row">


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
                        

            <div class="col-lg-12 text-center mt-5">
                <a href="packages.php" class="btn btn-sm btn-outline-dark rounded-1 fw-bold shawdow-none"> ***More Package***</a>
            </div>
        </div>
    </div>

  <!-- Facilities -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Facilities</h2>
    <div class="container mt-5 mb-4">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
        <?php 
          $res = selectAll('facilities');
          $path = FACILITIES_IMG_PATH;
          
          while($row = mysqli_fetch_assoc($res)){
            echo<<<data
                <div id="facAnimation" class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="$path$row[icon]" width="80px">
                    <h5 class="mt-3">$row[name]</h5>
                    
                </div>
            data;
          }
        
        
        ?>
          
        </div>
    </div>

<!-- Branches -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Branches</h2>

    <div class="cotainer mt-4">
        <div class="row">


            <?php 
                $res = select("SELECT * FROM `branches` WHERE`removed`=?",[0],'i');

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
                    

            <div class="col-lg-12 text-center mt-5">
                <a href="branches.php" class="btn btn-sm btn-outline-dark rounded-1 fw-bold shawdow-none"> ***More Branch***</a>
            </div>
        </div>
    </div>
    <!-- Testimonials -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Testimonials</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonial">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
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

                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-2</h6>
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

                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-3</h6>
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

                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-4</h6>
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

                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-5</h6>
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

                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="img/features/person.svg" width="30px">
                        <h6 class="m-0 ms-2">Random user-6</h6>
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
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
                <a href="about.php" class="btn btn-sm btn-outline-dark rounded-1 fw-bold shawdow-none">***Know more***</a>
            </div>
    </div>
   
    <!-- Reach Us -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-2 bg-white rounded">
                <iframe class="w-100 rounded"src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.566728501573!2d90.36015877487252!3d23.762825188300106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bfc93b126dd9%3A0x971c982a9f5b87d8!2sSmart%20Bachelor%20Bari!5e0!3m2!1sbn!2suk!4v1698235000469!5m2!1sbn!2suk"  height="500px" loading="lazy"></iframe>

                <h5 class="mt-2">Address</h5>
                <a href="https://www.google.com/maps/place/Smart+Bachelor+Bari/@23.7628252,90.3601588,17z/data=!4m14!1m7!3m6!1s0x3755bfc93b126dd9:0x971c982a9f5b87d8!2sSmart+Bachelor+Bari!8m2!3d23.7628203!4d90.3627337!16s%2Fg%2F11v9_vmg3c!3m5!1s0x3755bfc93b126dd9:0x971c982a9f5b87d8!8m2!3d23.7628203!4d90.3627337!16s%2Fg%2F11v9_vmg3c?entry=ttu" class="text-decoration-none" target="_blank">
                <i class="bi bi-geo-alt-fill"></i> ৪/২৮ শহীদ সলিমুল্লাহ রোড, ব্লক-ডি মোহাম্মদপুর ঢাকা-১২০৭ <br>
                                                   4/28 Shaheed Salimullah Road, Block-D Mohammadpur Dhaka-1207
                </a>
            </div>
            <div class="col-lg-4 col-md-8">
                <div class="bg-white p-4 mb-1 rounded">
                    <h5>Call us</h5>
                     <a href="tel: +8801792036518" class="d-inline-block mb-2 text-decoration-none text-dark"> <i class="bi bi-telephone-fill"></i>+8801327-809096</a>
                     <a href="tel: +8801792036518" class="d-inline-block mb-2 text-decoration-none text-dark"> <i class="bi bi-telephone-fill"></i>+8801327-809095</a>
                     <a href="tel: +8801792036518" class="d-inline-block mb-2 text-decoration-none text-dark"> <i class="bi bi-telephone-fill"></i>+8801327-809094</a>
                    <br>
                     <a href="mailto: abc@example.com" class="d-inline-block mb-2 text-decoration-none text-dark p-2"> <i class="bi bi-envelope-at-fill"></i>    smartbachelorbari@gmail.com</a>

                     <h5>Business hours</h5>
                     <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark"> <i class="bi bi-calendar-week"></i> Everyday</a>
                    <br>
                     <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark p-2"> <i class="bi bi-clock-history"></i>    9 am  -  7 pm</a>

                </div>

                <div class="bg-white p-4 mb-4 rounded">
                    <h5>Follow us</h5>
                    <br>
                        <a href="https://www.facebook.com/smartbachelorbari" target="_blank" class="d-inline-block mb-3"> 
                            <span class="badge bg-light text-dark fs-6 p-2 me-3">
                            <i class="bi bi-facebook me-1"></i>Facebook
                            </span>
                        </a>

                     <a href="https://www.tiktok.com/@smartbachelorbari" target="_blank" class="d-inline-block mb-3"> 
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-tiktok me-1"></i> Tiktok
                        </span>
                     </a>
                    <br>
                     <a href="#" target="_blank"class="d-inline-block mb-3 me-2"> 
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-instagram me-1"></i>Instagram
                        </span>
                     </a>
                    
                     <a href="https://www.linkedin.com/company/smartbachelorbari/about/" target="_blank" class="d-inline-block mb-3"> 
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-linkedin me-1"></i>Linkedin
                        </span>
                     </a>
                     <br>
                     <br>
                     <h5>Check-out our youtube Channel</h5>
                     <h6 style="color:#FF5733;">Do Subscribe to keep updated about offers</h6>
                     <a href="https://www.youtube.com/@SmartBachelorBari" target="_blank" class="d-inline-block mb-3"> 
                        <span class="badge bg-light text-dark fs-6 p-2">
                        <i class="bi bi-youtube me-1"></i> Youtube
                        </span>
                     </a>
                </div>

            </div>
        </div>
    </div>
     

    <!-- Password Reset modal and Code -->

    <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="recovery-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex"> <i class="bi bi-sheild-lock fs-3 me-2"></i> Set Up a New Password</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                   
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="pass" required class="form-control shadow-none">
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>

                      
                     
                        <div class="mb-2 text-end">
                            <button type="button" class="btn  shadow-none me-3"  data-bs-dismiss="modal">
                                Cancel
                                </button>
                            <button type="submit" class="btn btn-dark shadow-none justify-content-between me-3">Submit</button>
                            
                             
                        </div>
                    </div>
                  
                </form>
            </div>
        </div>
    </div>


    <?php require('inc/footer.php'); ?>


   <?php 
    if(isset($_GET['account_recovery']))
     {
        $data = filteration($_GET);
         
        date_default_timezone_set('Asia/Dhaka');

        $t_date = date("Y-m-d");

        $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1",[$data['email'],$data['token'],$t_date],'sss');

        if(mysqli_num_rows($query)==1){
           echo<<<showModal
                <script>
                var myModal = document.getElementById('recoveryModal');

                myModal.querySelector("input[name='email']").value = '$data[email]';
                myModal.querySelector("input[name='token']").value = '$data[token]';
                var modal = bootstrap.Modal.getOrCreateInstance(myModal);


                modal.show();


                </script>
           showModal;
        }else{
            alert("error","Invalid or Expired link !");
        }
     }
   ?>

  
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

    // recover account

    let recovery_form = document.getElementById('recovery-form');

    recovery_form.addEventListener('submit', (e)=>{
        e.preventDefault();


        let data = new FormData();

        data.append('email',recovery_form.elements['email'].value);
        data.append('token',recovery_form.elements['token'].value);
        data.append('pass',recovery_form.elements['pass'].value);
        
        data.append('recover_user','');

        var myModal = document.getElementById('recoveryModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php",true);

        xhr.onload = function(){
            if(this.responseText == 'failed')
            {
                alert('error',"Password Reset Failed");
            }
            else
            {
                alert('success',"Password Reset Successful!!");
                recovery_form.reset();
            }
            

        }
        xhr.send(data);
    });
    

  </script>
</body>
</html>