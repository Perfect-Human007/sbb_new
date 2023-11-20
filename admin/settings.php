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
    <title>Admin Panal - settings</title>

    <?php require('inc/links.php');?>
</head>
<body class="bg-light">
    
    <?php

    require('inc/header.php');


    ?>


    <div class="container-fluid" id="main-contant">
      <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
           <h3 class="mb-4">Settings</h3>


                  <!-- Shutdown -->
      <div class="card-body shadow mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="card-title m-0">Shutdown Website</h5>
            <div class="form-check form-switch shadow-none">
              <form action="">
              <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
              </form>
            </div>
          
        </div>
      
        
        <p class="card-text">No customers will be allowed to book hostel room, when shutdown mode is ON. </p>
      </div>

               <!-- General -->
           
              <div class="card-body shadow mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                   <h5 class="card-title m-0">General Settings</h5>
                   <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                   <i class="bi bi-pen"></i>  Edit
                    </button>
                </div>
               
                <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                <p class="card-text" id="site_title"></p>
                <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                <p class="card-text" id="site_about"></p>
                
               
              </div>
  

              
                <!-- Modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form id="general_s_form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">General Settings</h1>
                        
                      </div>
                      <div class="modal-body">
                        <div class=" mb-3">
                                  <label class="form-label">Site title</label>
                                  <input name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                        </div>
                        <div class=" mb-3">
                                <label class="form-label ">About Us</label>
                                <textarea name="site_about" id="site_about_inp" class="form-control shadow-none"  rows="6" required></textarea>
                        </div>
                    
                      </div>
                      <div class="modal-footer">
                        <button type="button" onclick="site_title.value = general_data.site_title , site_about.value = general_data.site_about" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn custom-bg text-light">Save</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
<!-- 

                About picture upload
                <div class="card border-0 shadow mb-4">
                <div class="card-body shadow">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <h5 class="card-title m-0">About Us Picture</h5>
                      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#about-s">
                      <i class="bi bi-person-add"></i>  Add
                        </button>
                    </div>
                  
                    <div class="row" id="about-data">
                    

                    </div>
                </div>
              </div> -->


                <!--  About us picture Modal -->
                <div class="modal fade" id="about-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form id="about_s_form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Picture</h1>
                      </div>
                      <div class="modal-body">
                        <div class=" mb-3">
                                <label class="form-label ">Picture</label>
                                <p>(Size: less then 5 MB)</p>
                                <input type="file" name="about_picture" accept=".jpg, .png, .webp, .jpeg" id="about_picture_inp" class="form-control shadow-none">
                        </div>
                      </div> 
                      <div class="modal-footer">
                        <button type="button" onclick="" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn custom-bg text-light">Save</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
               
              <!-- Management Team -->
              <div class="card border-0 shadow mb-4">
                <div class="card-body shadow">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <h5 class="card-title m-0">Management Team</h5>
                      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                      <i class="bi bi-person-add"></i>  Add
                        </button>
                    </div>
                  
                    <div class="row" id="team-data">
                    

                    </div>
                </div>
              </div>
                            
                <!--  Management Team Modal -->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form id="team_s_form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Member</h1>
                        
                      </div>
                      <div class="modal-body">
                        <div class=" mb-3">
                                  <label class="form-label">Name</label>
                                  <input type="text" name="member_name" id="member_name_inp" class="form-control shadow-none" required>
                        </div>
                        <div class=" mb-3">
                                <label class="form-label ">Picture</label>
                                <p>(Size: less then 5 MB)</p>
                                <input type="file" name="member_picture" accept=".jpg, .png, .webp, .jpeg" id="member_picture_inp" class="form-control shadow-none">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" onclick="" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn custom-bg text-light">Save</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>

          
            
        </div>
      </div>
    </div>


  <?php require('inc/scripts.php'); ?>
  <script src="scripts/settings.js"></script>

</body>
</html>