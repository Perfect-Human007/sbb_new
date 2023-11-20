<?php


      require('../inc/db_config.php');
      require('../inc/essential.php');
      adminLogin();



      if(isset($_POST['add_package']))
      {
            $features = filteration(json_decode($_POST['features']));
            $facilities = filteration(json_decode($_POST['facilities']));
            $frm_data = filteration($_POST);
            
            $flag = 0;
            $q1 = "INSERT INTO `packages`( `name`, `price`, `description`) VALUES (?,?,?)";
            $values = [$frm_data['name'],$frm_data['price'],$frm_data['desc']];
            if(insert($q1,$values,'sis')){
              $flag = 1;
            };
            $packages_id = mysqli_insert_id($con);
            

            $q2 ="INSERT INTO `package_facilities`( `packages_id`, `facilities_id`) VALUES (?,?)";

            if($stmt = mysqli_prepare($con,$q2)){
               foreach($facilities as $f){
                  mysqli_stmt_bind_param($stmt,'ii',$packages_id,$f);
                  mysqli_stmt_execute($stmt);
               }
               mysqli_stmt_close($stmt);
            }else{
               $flag = 0;
               die('query could not be prepared - insert');
            }

            $q3 ="INSERT INTO `package_features`( `packages_id`, `features_id`) VALUES (?,?)";

            if($stmt = mysqli_prepare($con,$q3)){
               foreach($features as $f){
                  mysqli_stmt_bind_param($stmt,'ii',$packages_id,$f);
                  mysqli_stmt_execute($stmt);
               }
               mysqli_stmt_close($stmt);
            }else{
               $flag = 0;
               die('query could not be prepared - insert');
            }

            if($flag){
               echo 1;
            }else{
               echo 0;
            }
   
      }

      if(isset($_POST['get_packages']))
      {
         $res= select("SELECT * FROM `packages` WHERE `removed`=?",[0],'i');
         $i=1;

         
         while($row = mysqli_fetch_assoc($res)){
            if($row['status']==1){
               $status = "
                   <button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>
               ";
            }else{
               $status = "
                  <button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>
               ";
            }
            echo <<<data

               <tr class='align-middle'>
                  <td>$i</td>
                  <td>$row[name]</td>
                  <td>৳ $row[price]</td>
                  <td>$status</td>
                  <td><button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm'     data-bs-toggle='modal'         data-bs-target='#edit-package'>
                        <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button type='button' onclick="package_images($row[id],'$row[name]')" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal'         data-bs-target='#package-images'>
                        <i class="bi bi-images"></i> Edit
                        </button>

                        <button type='button' onclick='remove_package($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class="bi bi-trash"></i>
                        </button>
                  </td>
              
               </tr>
            


            data;
            $i++;
         }
         
      }

      if(isset($_POST['get_package'])){
         $frm_data= filteration($_POST);

         $res1 = select("SELECT * FROM `packages` WHERE `id`=?",[$frm_data['get_package']],'i');
         $res2 = select("SELECT * FROM `package_features` WHERE `packages_id`=?",[$frm_data['get_package']],'i');
         $res3 = select("SELECT * FROM `package_facilities` WHERE `packages_id`=?",[$frm_data['get_package']],'i');

         $packagedata = mysqli_fetch_assoc($res1);
         $features = [];
         $facilities = [];

         if(mysqli_num_rows($res2)>0){
            while($row = mysqli_fetch_assoc($res2)){
               array_push($features,$row['features_id']);
            }
         }

         if(mysqli_num_rows($res3)>0){
            while($row = mysqli_fetch_assoc($res3)){
               array_push($facilities,$row['facilities_id']);
            }
         }

         $data = ["packagedata"=> $packagedata, "features"=> $features, "facilities"=> $facilities];

         $data = json_encode($data);

         echo $data;
      }

      if(isset($_POST['edit_package'])){
         $features = filteration(json_decode($_POST['features']));
         $facilities = filteration(json_decode($_POST['facilities']));
         $frm_data = filteration($_POST);
         
         $flag = 0;

         $q1 = "UPDATE `packages` SET `name`=?,`price`=?,`description`=? WHERE `id`= ?";

         $values = [$frm_data['name'],$frm_data['price'],$frm_data['desc'],$frm_data['packages_id']];

         if(update($q1,$values,'sisi')){
            $flag = 1;
         }

         $del_features = delete("DELETE FROM `package_features` WHERE `packages_id`=?",[$frm_data['packages_id']],'i');
         $del_facilities = delete("DELETE FROM `package_facilities` WHERE `packages_id`=?",[$frm_data['packages_id']],'i');

         if(!($del_facilities && $del_features)){
            $flag = 0;
         }

         $q2 ="INSERT INTO `package_facilities`( `packages_id`, `facilities_id`) VALUES (?,?)";

         if($stmt = mysqli_prepare($con,$q2)){
            foreach($facilities as $f){
               mysqli_stmt_bind_param($stmt,'ii',$frm_data['packages_id'],$f);
               mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
         }else{
            $flag = 0;
            die('query could not be prepared - insert');
         }

         $q3 ="INSERT INTO `package_features`( `packages_id`, `features_id`) VALUES (?,?)";

         if($stmt = mysqli_prepare($con,$q3)){
            foreach($features as $f){
               mysqli_stmt_bind_param($stmt,'ii',$frm_data['packages_id'],$f);
               mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
         }else{
            $flag = 0;
            die('query could not be prepared - insert');
         }

         if($flag){
            echo 1;
         }else{
            echo 0;
         }

      }

      if(isset($_POST['toggle_status'])){
         $frm_data= filteration($_POST);
         $q= "UPDATE `packages` SET `status`=? WHERE `id`=?";
         $v = [$frm_data['value'],$frm_data['toggle_status']];

         if(update($q,$v,'ii')){
            echo 1;
         }else{
            echo 0;
         }
      }

      if(isset($_POST['add_image']))
      {

         $frm_data = filteration($_POST);
         $img_r =  uploadIamge($_FILES['image'],PACKAGES_FOLDER);

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
          $q = "INSERT INTO `package_images`(`package_id`, `image`) VALUES (?,?)";
          $values = [$frm_data['package_id'],$img_r];
          $res = insert($q,$values,'is');
          echo $res;
         }
      }

      
      if(isset($_POST['get_package_images']))
      {

         $frm_data = filteration($_POST);
         $res = select("SELECT * FROM `package_images` WHERE `package_id`=?" , [$frm_data['get_package_images']],'i');
         $path = PACKAGES_IMG_PATH;
         
         while($row = mysqli_fetch_assoc($res)){
              if($row['thumb']==1){
               $thunb_btn = "<i class='bi bi-check2 text-light bg-success px-2 py-1 rounded fs-5'></i>";
              }else{
               $thunb_btn = "<button type='button' onclick='thumb_image($row[sr_no],$row[package_id])' class='btn btn-secondary shadow-none'  </button> <i class='bi bi-check2 text-light px-2 py-1 rounded fs-5'>";
              };

            echo<<<data
              <tr class='align-middle'>
                <td><img src='$path$row[image]' class='img-fluid'></td>
                <td>$thunb_btn</td>
                <td> <button type='button' onclick='rem_image($row[sr_no],$row[package_id])' class='btn btn-danger shadow-none' </button>
                 <i class="bi bi-trash"></i> Delete
                </td>
              </tr>
            data;
         }
      }

      if(isset($_POST['rem_image']))
      {
          $frm_data = filteration($_POST);
          $values = [$frm_data['image_id'],$frm_data['package_id']];

          $pre_q = "SELECT * FROM `package_images` WHERE `sr_no`=? AND `package_id`=?";
          $res= select($pre_q,$values,'ii');
          $img = mysqli_fetch_assoc($res);

          if(deleteImage($img['image'],PACKAGES_FOLDER))
          {
            $q ="DELETE FROM `package_images` WHERE `sr_no`=? AND `package_id`=?";
            $res = delete($q,$values,'ii');
            echo $res;
          }else{
              echo 0;
          }
      }

      if(isset($_POST['thumb_image']))
      {
          $frm_data = filteration($_POST);
          
          $pre_q = "UPDATE `package_images` SET `thumb`=? WHERE `package_id`=?";
          $pre_v = [0,$frm_data['package_id']];
          $pre_res = update($pre_q ,$pre_v,'ii');

          $q = "UPDATE `package_images` SET `thumb`=? WHERE `sr_no`=? AND `package_id`=?";
          $v = [1,$frm_data['image_id'],$frm_data['package_id']];
          $res = update($q ,$v,'iii');

          echo $res;
      }

      if(isset($_POST['remove_package']))
      {
         $frm_data = filteration($_POST);

         $res1 = select("SELECT * FROM `package_images` WHERE `package_id`=?", [$frm_data['package_id']],'i');

         while($row = mysqli_fetch_assoc($res1)){
           deleteImage($row['image'],PACKAGES_FOLDER);
         }

         $res2 = delete("DELETE FROM `package_images` WHERE `package_id`=?", [$frm_data['package_id']],'i');
         $res3 = delete("DELETE FROM `package_features` WHERE `packages_id`=?", [$frm_data['package_id']],'i');
         $res4 = delete("DELETE FROM `package_facilities` WHERE `packages_id`=?", [$frm_data['package_id']],'i');
         $res5 = update("UPDATE `packages` SET `removed`=? WHERE `id`=?", [1,$frm_data['package_id']],'ii');

         if($res2 || $res3 || $res4 || $res5){
            echo 1;
         }else{
            echo 0;
         }
      }





?>