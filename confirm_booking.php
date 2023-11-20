<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari-Confirm Bookings</title>
   
   <style>
    body{
      width:100%;
      overflow-x:hidden !important; 
      
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

    /*
        check room id from url is present or not

        Shutdow mode is active or not

        User is logged in or not
    */
      if(!isset($_GET['id']) || $settings_r['shutdown']==true){
        redirect('packages.php');
      }
      elseif(!(isset($_SESSION['login']) && $_SESSION['login']=true)){
        redirect('packages.php');
      }

      // Filter to get package/room and user data

      $data = filteration($_GET);

      $room_res = select("SELECT * FROM `packages` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');
      if(mysqli_num_rows($room_res)==0){
        redirect('packages.php');
      }

      $room_data = mysqli_fetch_assoc($room_res);

      $book_btn ="";

      if(!$settings_r['shutdown']){
          $book_btn = "<a href='#' class='btn btn-sm text-white shadow-none custom-bg'>Book Now</a>";
      }

      $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false,
      ];
        
      $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",
      [$_SESSION['uId']],"i");
      $user_data = mysqli_fetch_assoc($user_res);
    ?>

          

      <div class="cotainer mt-1">
          <div class="row">
            
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold h-font text-center">Confirm Booking</h2>
              <div class="h-line bg-dark"></div>
              <br>
              <div class="text-center" style ="font-size: 14px;">
                <a href="index.php" class="text-escondary text-decoration-none text-dark">HOME</a>
                <span class="text-escondary"> > </span>
                <a href="packages.php" class="text-escondary text-decoration-none text-dark">Packages/Rooms</a>
                <span class="text-escondary"> > </span>
                <a href="#" class="text-escondary text-decoration-none text-dark">Confirm</a>
              </div>
            </div>

            <div class="col-lg-7 col-md-12 px-5">
              
              <?php
                  $room_thumb = PACKAGES_IMG_PATH."thumbnail.jpg";
                  $thumb_q = mysqli_query($con,"SELECT * FROM `package_images` WHERE `package_id`='$room_data[id]' AND `thumb`='1'");
  
                  if(mysqli_num_rows($thumb_q)>0){
                      $thumb_res = mysqli_fetch_assoc($thumb_q);
                      $room_thumb = PACKAGES_IMG_PATH.$thumb_res['image'];
  
                  }
  
                  $book_btn ="";
  
                  if(!$settings_r['shutdown']){
                      $book_btn = "<a href='#' class='btn btn-sm text-white shadow-none custom-bg'>Book Now</a>";
                  }

                  echo<<<data
                      <div class="card p-3 shadow-sm rounded">
                        
                        <h5>$room_data[name]</h5>
                        <h6 class="mb-4">৳ $room_data[price] per month</h6>
                        <img src="$room_thumb" class="img-fulid rounded mb-3">
                      </div>
                  data;
  
              
              ?>
            </div>
             
            <div class="col-lg-5 col-md-12 px-4 ">
              <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body ">
                  <form action="pay_now.php" method="POST" id="booking_form">
                    <h5 class="mb-2">Booking Details</h5>
                    <div class="col-md-12 mb-3 px-4 border border-danger rounded">
                    <h6 class="mb-3 mt-2">Attention Notice: <br>
                    Please be advised that room bookings can only be made at the <span class="text-danger"> BEGINNING (Ex: 01-01-2023) of each MONTH to END(Ex: 31-01-2023) of each MONTH.</span> <br> To Reserve outside this timeframe Contact with Authority <a href="contact.php" class="text-decoration-none">Contact</a>. </h6>
                    </div>
                    <div class="row">
                       <div class="col-md-6 mb-3">
                          <label class="form-label">Name</label>
                          <input name="name" type="text" value="<?php echo $user_data['name']?>" class="form-control shadow-none" required>
                       </div>
                       <div class="col-md-6 mb-3">
                          <label class="form-label">Phone Number</label>
                          <input name="name" type="number" value="<?php echo $user_data['phonenum']?>" class="form-control shadow-none" required>
                       </div>
                       <div class="col-md-12 mb-3">
                          <label class="form-label">Address</label>
                          <textarea name="address" class="form-control shadow-none" required rows="1"><?php echo $user_data['address']?></textarea>
                       </div>
                       <div class="col-md-12 mb-3">
                          <label for="branch">Select Branch:</label>
                          <select id="branch" name="branch">
                              <?php
                               $res = selectAll('branches');
                               while($row = mysqli_fetch_assoc($res)){
                                echo<<<data
                                  <option value='$row[name]'>$row[name]($row[address])</option>
                                data;
                              }
                              ?>
                          </select>
                         
                       </div>
                       <div class="col-md-6 mb-3">
                          <label class="form-label">Check-in</label>
                          <input name="checkin" id="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                       </div>
                       <div class="col-md-6 mb-4">
                          <label class="form-label">Check-out</label>
                          <input name="checkout" id="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                       </div>
                       
                       <div class="col-md-12 mb-1">
                          <div class="spinner-border text-warning mb-3 d-none" id="info_loader" role="status">
                              <span class="visually-hidden">Loading...</span>
                          </div>
                          <h6 class="text-danger" id="pay_info">Please provide check-in & check-out date</h6>
                          <button name="pay_now"class="btn w-100 text-white custom-bg shadow-none mt-1 mb-1" disabled>Pay Now</button>
                       </div>
                    </div>
                  </form>
                   
                </div>
              </div>
            </div>
           
            
           

              


              
          </div>
      </div>
  


    <?php require('inc/footer.php'); ?>


 

  
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

  <script>
   
    let booking_form = document.getElementById('booking_form');
    let info_loader = document.getElementById('info_loader');
    let pay_info = document.getElementById('pay_info');
  

    function check_availability(){
        let checkin_val = booking_form.elements['checkin'].value;
        let checkout_val = booking_form.elements['checkout'].value;

        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if(checkin_val!='' && checkout_val!=''){
           
          pay_info.classList.add('d-none');
          pay_info.classList.replace('text-dark','text-danger');
          info_loader.classList.remove('d-none');

          data = new FormData();

          data.append('check_availability','');
          data.append('check_in',checkin_val);
          data.append('check_out',checkout_val);

          let xhr = new XMLHttpRequest();
          xhr.open("POST","ajax/confirm_booking.php",true);

          xhr.onload = function(){
             
            let data = JSON.parse(this.responseText)
            var formattedDays = data.days2;
            if(data.status == 'check_in_out_equal'){
              pay_info.innerText = "You cannot check-out on the same day!";
            }
            else if(data.status == 'check_out_earlier'){
              pay_info.innerText = "Check-out is earlier then check-in date!";
            }
            else if(data.status == 'check_in_earlier'){
              pay_info.innerText = "Check-out is earlier then today's date!";
            } 
            else if(data.status == 'unavailable'){
              pay_info.innerText = "Room's not available!";
            }else{
              pay_info.innerHTML = "Number of Month: "+data.days+"<br><br>Total Amount: ৳"+data.payment;
              pay_info.classList.replace('text-danger','text-dark');
              booking_form.elements['pay_now'].removeAttribute('disabled');

            }
          pay_info.classList.remove('d-none');
  
          info_loader.classList.add('d-none');

          }
          xhr.send(data);
        }
    }
  </script>
</body>
</html>