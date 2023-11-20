<?php
  
  require('inc/essential.php');
  require('inc/db_config.php');
  adminLogin();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal - facilities</title>

    <?php require('inc/links.php');?>
</head>
<body class="bg-light">
    
<?php
  
  require('inc/header.php');
  

?>


    <div class="container-fluid" id="main-contant">
      <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
           <h3 class="mb-4">Feature and Facilities</h3>

           <div class="card border-0 shadow-sm mb-4">
              <div class = "card-body">
                   <div class="d-flex align-items-center justify-content-between mb-3">
                      <h5 class="card-title m-0">Features</h5>
                      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                      <i class="bi bi-folder-plus"></i></i>  Add
                        </button>
                    </div>
                  

                 <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                    <table class="table table-hover border">
                        <thead>
                          <tr class="bg-dark text-light">
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Action</th>
                            
                          </tr>

                        </thead>
                        <tbody id="features-data">

                        </tbody>
                    </table>
                 </div>


              </div>
           </div>
           

           <div class="card border-0 shadow-sm mb-4">
              <div class = "card-body">
                   <div class="d-flex align-items-center justify-content-between mb-3">
                      <h5 class="card-title m-0">Facilities</h5>
                      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                      <i class="bi bi-folder-plus"></i></i>  Add
                        </button>
                    </div>
                  

                 <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                    <table class="table table-hover border">
                        <thead>
                          <tr class="bg-dark text-light">
                              <th scope="col">#</th>
                              <th scope="col">Icon</th>
                              <th scope="col">Name</th>
                              <th scope="col" width="40%">Description</th>
                              <th scope="col">Action</th>
                            
                          </tr>

                        </thead>
                        <tbody id="facilities-data">

                        </tbody>
                    </table>
                 </div>


              </div>
           </div>
          
            
        </div>
      </div>
    </div>
    

      <!--  Feature Modal -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="feature_s_form">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add Feature</h1>
            
          </div>
          <div class="modal-body">
            <div class=" mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" name="feature_name"  class="form-control shadow-none" required>
            </div>
          
          </div>
          <div class="modal-footer">
            <button type="reset" onclick="" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit"  class="btn custom-bg text-light">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>

      <!-- Facilities Modal -->
      <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="facility_s_form">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Add Facility</h1>
                
              </div>
              <div class="modal-body">
                <div class=" mb-3">
                          <label class="form-label">Name</label>
                          <input type="text" name="facility_name" class="form-control shadow-none" required>
                </div>
                <div class=" mb-3">
                        <label class="form-label ">Icon</label>
                       
                        <input type="file" name="facility_icon" accept=".svg" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                  <label class="form-label ">Description</label>
                  <textarea name="facility_desc" class="form-control shadow-none"  rows="3"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" onclick="" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit"  class="btn custom-bg text-light">Save</button>
              </div>
            </div>
            </form>
          </div>
      </div>



      <?php require('inc/scripts.php'); ?>
      <script src="scripts/facilities.js"></script>
</body>
</html>