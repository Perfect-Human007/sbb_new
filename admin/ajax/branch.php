<?php


      require('../inc/db_config.php');
      require('../inc/essential.php');
      adminLogin();



      if(isset($_POST['add_branch']))
      {
           
         $frm_data = filteration($_POST);
         
         
         $q1 = "INSERT INTO `branches`( `name`, `address`, `description`) VALUES (?,?,?)";
         $values = [$frm_data['name'],$frm_data['address'],$frm_data['desc']];
         if(insert($q1,$values,'sss')){
            echo 1;
         }else{
            echo 0;
         }
   
      }

      if(isset($_POST['get_branches']))
      {
         $res= selectAll('branches');
          
         $i=1;
         while($row=mysqli_fetch_assoc($res))
         {
            echo <<<data

               <tr class='align-middle'>
                  <td>$i</td>
                  <td>$row[name]</td>
                  <td> $row[address]</td>
                  
                  <td><button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm'     data-bs-toggle='modal'         data-bs-target='#edit-branch'>
                        <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button type='button' onclick="branch_images($row[id],'$row[name]')" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal'         data-bs-target='#branch-images'>
                        <i class="bi bi-images"></i> Edit
                        </button>

                        <button type='button' onclick='remove_branch($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class="bi bi-trash"></i>
                        </button>
                  </td>
              
               </tr>
            


            data;
            $i++;
         }
         
      }

      if(isset($_POST['get_branch'])){
         $frm_data= filteration($_POST);

         $res1 = select("SELECT * FROM `branches` WHERE `id`=?",[$frm_data['get_branch']],'i');
         

         $branchdata = mysqli_fetch_assoc($res1);
       

         $data = ["branchdata"=> $branchdata];

         $data = json_encode($data);

         echo $data;
      }

      if(isset($_POST['edit_branch'])){
     
         $frm_data = filteration($_POST);
         
         $flag = 0;

         $q1 = "UPDATE `branches` SET `name`=?,`address`=?,`description`=? WHERE `id`= ?";

         $values = [$frm_data['name'],$frm_data['address'],$frm_data['desc'],$frm_data['branches_id']];

         if(update($q1,$values,'sssi')){
            $flag = 1;
         }

         if($flag){
            echo 1;
         }else{
            echo 0;
         }

      }


      if(isset($_POST['add_image']))
      {

         $frm_data = filteration($_POST);
         $img_r =  uploadIamge($_FILES['image'],BRANCHES_FOLDER);

         if($img_r == 'inv_img'){
          echo $img_r;
         }
         else if($img_r == 'inv_size'){
          echo $img_r;
         }
         else if($img_r == 'upd_failed'){
          echo $img_r;
         }
         else{
          $q = "INSERT INTO `branch_images`(`branch_id`, `image`) VALUES (?,?)";
          $values = [$frm_data['branch_id'],$img_r];
          $res = insert($q,$values,'is');
          echo $res;
         }
      }

      
      if(isset($_POST['get_branch_images']))
      {

         $frm_data = filteration($_POST);
         $res = select("SELECT * FROM `branch_images` WHERE `branch_id`=?" , [$frm_data['get_branch_images']],'i');
         $path = BRANCHES_IMG_PATH;
         
         while($row = mysqli_fetch_assoc($res)){
              if($row['thumb']==1){
               $thunb_btn = "<i class='bi bi-check2 text-light bg-success px-2 py-1 rounded fs-5'></i>";
              }else{
               $thunb_btn = "<button type='button' onclick='thumb_image($row[sr_no],$row[branch_id])' class='btn btn-secondary shadow-none'  </button> <i class='bi bi-check2 text-light px-2 py-1 rounded fs-5'>";
              };

            echo<<<data
              <tr class='align-middle'>
                <td><img src='$path$row[image]' class='img-fluid'></td>
                <td>$thunb_btn</td>
                <td> <button type='button' onclick='rem_image($row[sr_no],$row[branch_id])' class='btn btn-danger shadow-none' </button>
                 <i class="bi bi-trash"></i> Delete
                </td>
              </tr>
            data;
         }
      }

      if(isset($_POST['rem_image']))
      {
          $frm_data = filteration($_POST);
          $values = [$frm_data['image_id'],$frm_data['branch_id']];

          $pre_q = "SELECT * FROM `branch_images` WHERE `sr_no`=? AND `branch_id`=?";
          $res= select($pre_q,$values,'ii');
          $img = mysqli_fetch_assoc($res);

          if(deleteImage($img['image'],BRANCHES_FOLDER))
          {
            $q ="DELETE FROM `branch_images` WHERE `sr_no`=? AND `branch_id`=?";
            $res = delete($q,$values,'ii');
            echo $res;
          }else{
              echo 0;
          }
      }

      if(isset($_POST['thumb_image']))
      {
          $frm_data = filteration($_POST);
          
          $pre_q = "UPDATE `branch_images` SET `thumb`=? WHERE `branch_id`=?";
          $pre_v = [0,$frm_data['branch_id']];
          $pre_res = update($pre_q ,$pre_v,'ii');

          $q = "UPDATE `branch_images` SET `thumb`=? WHERE `sr_no`=? AND `branch_id`=?";
          $v = [1,$frm_data['image_id'],$frm_data['branch_id']];
          $res = update($q ,$v,'iii');
 
          echo $res;
      }

      if(isset($_POST['remove_branch']))
      {
         $frm_data = filteration($_POST);

         $res1 = select("SELECT * FROM `branch_images` WHERE `branch_id`=?", [$frm_data['branch_id']],'i');

         while($row = mysqli_fetch_assoc($res1)){
           deleteImage($row['image'],BRANCHES_FOLDER);
         }

         $res2 = delete("DELETE FROM `branch_images` WHERE `branch_id`=?", [$frm_data['branch_id']],'i');

         $res5 = delete("DELETE FROM `branches` WHERE `id`=?", [$frm_data['branch_id']],'i');

         if($res2 || $res5){
            echo 1;
         }else{
            echo 0;
         }
      }





?>