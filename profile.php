<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <?php require('inc/links.php'); ?>
    <title>Smart Bachelor Bari- Profile</title>
   
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

    <?php 
      require('inc/header.php'); 
      
      if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('index.php');
      }
       
      $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'s');

      if(mysqli_num_rows($u_exist)==0){
        redirect('index.php');
      }
      $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>

   
   

          

      <div class="container">
          <div class="row">
            
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Profile</h2>
              
              <div style ="font-size: 14px;">
                <a href="index.php" class="text-escondary text-decoration-none text-dark">HOME</a>
                <span class="text-escondary"> > </span>
                <a href="packages.php" class="text-escondary text-decoration-none text-dark">Profile</a>
              </div>
            </div>



            <div class="col-12 mb-5 px-4">
               <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                  <form id="info-form">
                    <h5 class="mb-3 fw-bold">Basic Informatiom</h5>
                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" value="<?php echo $u_fetch['name']?>" class="form-control shadow-none" required>
                      </div>

                      <div class="col-md-4 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input name="phonenum" type="text" value="<?php echo $u_fetch['phonenum']?>"  class="form-control shadow-none" required>
                      </div>

                      <div class="col-md-4 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input name="dob" type="date" value="<?php echo $u_fetch['dob']?>" required class="form-control shadow-none">
                      </div>

                      <div class="col-md-4 mb-3">
                        <label class="form-label">Pincode</label>
                        <input name="pincode" type="number" value="<?php echo $u_fetch['pincode']?>"  class="form-control shadow-none">
                      </div>

                      <div class="col-md-8 mb-4">
                        <label class="form-label ">Address</label>
                        <textarea name="address" class="form-control shadow-none" required rows="1"><?php echo $u_fetch['address']?> </textarea>
                      </div>

                    </div>
                    <button type="submit" class="btn btn-dark shadow-none">Save Changes</button>
                  </form>
               </div>
            </div>

            <div class="col-md-4 mb-5 px-4">
               <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                  <form id="profile-form">
                    <h5 class="mb-3 fw-bold">Profile Picture</h5>
                    <img src="<?php echo USERS_IMG_PATH.$u_fetch['profile']?>" class="rounded-circle img-fluid mb-4">
                    <label class="form-label">Upload Picture</label>
                    <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp"class="form-control shadow-none">
                    <button type="submit" class="btn btn-dark shadow-none mt-4">Save Changes</button>
                  </form>
               </div>
            </div>


            <div class="col-8 mb-5 px-4">
               <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                  <form id="pass-form">
                    <h5 class="mb-3 fw-bold">Change Password</h5>
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">New Password</label>
                        <input name="new_pass" id="myInput" type="password"  class="form-control shadow-none" required>
                      </div>

                      <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input name="confirm_pass" id="myInput" type="password"  class="form-control shadow-none" required>
                      </div>

                      <div class="col-md-6 mb-3">
                      <input type="checkbox" onclick="myFunction()">
                      <label class="form-label">Show Password</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-dark shadow-none">Save Changes</button>
                  </form>
               </div>
            </div>

              
          </div>
      </div>
  


    <?php require('inc/footer.php'); ?>


  <script>
    let info_form = document.getElementById('info-form');

    info_form.addEventListener('submit', function(e){
      e.preventDefault();

      let data = new FormData();
      data.append('info_form','');
      data.append('name',info_form.elements['name'].value);
      data.append('phonenum',info_form.elements['phonenum'].value);
      data.append('dob',info_form.elements['dob'].value);
      data.append('pincode',info_form.elements['pincode'].value);
      data.append('address',info_form.elements['address'].value);

      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/profile.php",true);
        
        xhr.onload = function(){
          if(this.responseText=='phone_already'){
             alert('error',"Phone number is already registerd!");
          }
          else if(this.responseText==0){
            alert('error',"No Changes made!")
          }
          else{
            alert('success',"Changes Saved!!")
          }
        }
      xhr.send(data);
    })

    let profile_form = document.getElementById('profile-form');

    profile_form.addEventListener('submit', function(e){
      e.preventDefault();

      let data = new FormData();
      data.append('profile_form','');
      data.append('profile',profile_form.elements['profile'].files[0]);
     

      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/profile.php",true);
        
        xhr.onload = function(){
          if(this.responseText == 'inv_img')
           {
            alert('error',"ONLY JPG, PNG AND WEBP images are allowed");
           }
           else if(this.responseText == 'upd_failed')
           {
            alert('error',"Image upload failed");
           }
          else{
            window.location.href=window.location.pathname;
            
          }
        }
      xhr.send(data);
    })

    let pass_form = document.getElementById('pass-form');

    pass_form.addEventListener('submit', function(e){
      e.preventDefault();

      let new_pass = pass_form.elements['new_pass'].value;
      let confirm_pass = pass_form.elements['confirm_pass'].value;

      if(new_pass != confirm_pass){
        alert('error','Password do not match!');
        return false;
      }


      let data = new FormData();
      data.append('pass_form','');
      data.append('new_pass',new_pass);
      data.append('confirm_pass',confirm_pass);
     

      let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/profile.php",true);
        
        xhr.onload = function(){
          if(this.responseText == 'mismatch')
           {
            alert('error',"Pasword do not match!");
           }
           else if(this.responseText == 'upd_failed')
           {
            alert('error',"Password upadation failed");
           }
          else{
            alert('success',"Password Updated!!");
            pass_form.reset();
          }
        }
      xhr.send(data);
    })

    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>
</html>