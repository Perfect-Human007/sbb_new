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
    <title>Admin Panal - branches</title>

    <?php require('inc/links.php');?>
</head>
<body class="bg-light">
    
<?php
  
  require('inc/header.php');
  

?>


    <div class="container-fluid" id="main-contant">
      <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
           <h3 class="mb-4">Branches</h3>

           <div class="card border-0 shadow-sm mb-4">
              <div class = "card-body">
              
                   <div class="text-end mb-4">
                     
                      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-branch">
                      <i class="bi bi-building-add"></i></i>  Add
                        </button>
                    </div>
                  

                 <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                    <table class="table table-hover border text-center rounded">
                        <thead>
                          <tr class="bg-dark text-light">
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Address</th>
                              <th scope="col">Action</th>
                            
                          </tr>

                        </thead>
                        <tbody id="branch-data">

                        </tbody>
                    </table>
                 </div>


              </div>
           </div>
           

            
        </div>
      </div>
    </div>
    


      <!--  Add branch Modal -->
    <div class="modal fade" id="add-branch" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <form id="add_branch_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add Branch</h1>
            
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"  class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                        <label class="form-label ">Address</label>
                        <textarea name="address" class="form-control shadow-none" required rows="1"></textarea>
              </div>

              <div class="col-12 mb-3">
              <label class="form-label fw-bold">Description</label>
              <textarea name="desc" rows="5" class="form-control shadow-none" required></textarea>
              </div>
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

    <!--  edit branch Modal -->
    <div class="modal fade" id="edit-branch" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <form id="edit_branch_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Edit Branch</h1>
            
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"  class="form-control shadow-none" required>
              </div>

              <div class="col-md-6 mb-3">
                        <label class="form-label ">Address</label>
                        <textarea name="address" class="form-control shadow-none" required rows="1"></textarea>
              </div>

              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="desc" rows="5" class="form-control shadow-none" required></textarea>
              </div>

              <input type="hidden"  name="branches_id">
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

    <!-- Manage pakage images modal -->
    
    <div class="modal fade" id="branch-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Branch name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="image-alert">

            </div>
            <div class="border-bottom border-3 pb-3 mb-3">
              <form id="add_image_form">
              <label class="form-label fw-bold">Add Image</label>
              <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
              <button   class="btn custom-bg text-light">Add</button>
              <input type="hidden" name="branch_id">
              </form>
            </div>
            <div class="table-responsive-lg" style="height: 550px; overflow-y: scroll;">
              <table class="table table-hover border text-center rounded">
                  <thead>
                    <tr class="bg-dark text-light sticky-top">
                        <th scope="col" width="60%">Image</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Action</th>
                      
                    </tr>

                  </thead>
                  <tbody id="branch-image-data">

                  </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>






  <?php require('inc/scripts.php'); ?>
  
  <script src="scripts/branch.js"></script>
</body>
</html>