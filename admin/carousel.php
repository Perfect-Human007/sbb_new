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
    <title>Admin Panal - carousel</title>

    <?php require('inc/links.php');?>
</head>
<body class="bg-light">
    
<?php
  
  require('inc/header.php');
  

?>


    <div class="container-fluid" id="main-contant">
      <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
           <h3 class="mb-4">Carousel</h3>


              <!-- Carousel section -->
           
              <div class="card-body shadow mb-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title m-0">Images</h5>
                    <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#carousel-s">
                    <i class="bi bi-file-plus"></i>  Add
                      </button>
                  </div>
                
                  <div class="row" id="carousel-data">
                   

                  </div>
              </div>

                            
                <!--  Carousel  Modal -->
                <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <form id="carousel_s_form">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Image</h1>
                        
                      </div>
                      <div class="modal-body">
                     
                        <div class=" mb-3">
                                <label class="form-label ">Picture</label>
                                <p>(Size: less then 5 MB)</p>
                                <input type="file" name="carousel_picture" accept=".jpg, .png, .webp, .jpeg" id="carousel_picture_inp" class="form-control shadow-none">
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
     <script src="scripts/carousel.js"></script>

</body>
</html>