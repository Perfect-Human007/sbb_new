<?php


      require('../inc/db_config.php');
      require('../inc/essential.php');
      adminLogin();


      if(isset($_POST['add_booking']))
      {

         $frm_data = filteration($_POST);
         $img_r =  uploadIamge($_FILES['proof'],BOOKINGS_FOLDER);

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
            $q = "INSERT INTO `offline_bookings`(`name`, `payment`, `description`, `proof`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'],$frm_data['payment'],$frm_data['offbookings_desc'],$img_r];
            $res = insert($q,$values,'siss');
            echo $res;
         }
      }

      if(isset($_POST['get_bookings']))
      {
         $res= selectAll('offline_bookings');
         $i=1;
         $path= BOOKINGS_IMG_PATH;
         while($row = mysqli_fetch_assoc($res)){
            
            echo <<<data

               <tr>
                  <td>$i</td>
                  
                  <td>$row[name]</td>
                  <td>$row[payment] BDT</td>
                  <td>$row[description]</td>
                  <td><img src="$path$row[proof]" width="60px"></td>
                  <td> <button type="button" onclick="rem_booking($row[id])" class="btn btn-danger btn-sm shadow-none">
                  <i class="bi bi-trash3"></i> Delete
                  </button></td>
               </tr>
            


            data;
            $i++;
         }
         
      }

      if(isset($_POST['rem_booking']))
      {
            $frm_data = filteration($_POST);
            $values = [$frm_data['rem_booking']];

         
               if(deleteImage($img['proof'],FACILITIES_FOLDER))
               {
               $q ="DELETE FROM `offline_bookings` WHERE `id`=?";
               $res = delete($q,$values,'i');
               echo $res;
               }else{
                  echo 0;
               }
          
        }
     



?>