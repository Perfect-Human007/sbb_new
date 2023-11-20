<?php
 
 //for frontend
   define('SITE_URL', 'http://127.0.0.1/sbb/');
   define('ABOUT_IMG_PATH', SITE_URL.'img/about/');
   define('CAROUSEL_IMG_PATH', SITE_URL.'img/carousel/');
  
   define('FACILITIES_IMG_PATH', SITE_URL.'img/facilities/');
   define('PACKAGES_IMG_PATH', SITE_URL.'img/packages/');
   define('BRANCHES_IMG_PATH', SITE_URL.'img/branches/');
   define('BOOKINGS_IMG_PATH', SITE_URL.'img/bookings/');
   define('USERS_IMG_PATH', SITE_URL.'img/users/');


  //for backend
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/sbb/img/' );
    define('ABOUT_FOLDER', 'about/');
    define('CAROUSEL_FOLDER', 'carousel/');
    define('FACILITIES_FOLDER', 'facilities/');
    define('PACKAGES_FOLDER', 'packages/');
    define('BRANCHES_FOLDER', 'branches/');
    define('BOOKINGS_FOLDER', 'bookings/');
    define('USERS_FOLDER', 'users/');

    // sendgrid api key

    define('SENDGRID_API_KEY',"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");
    define('SENDGRID_EMAIL',"perfecthumancool@gmail.com");
    define('SENDGRID_NAME',"Smart Bachelor Bari");


      function adminLogin(){
          session_start();
          if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
              echo"<script>
                    window.location.href='index.php';
                  </script>";
          }
          // session_regenerate_id(true);
      }


      function redirect($url){

          echo"<script>
            window.location.href='$url';
            </script>";
      }

      function alert($type,$msg)
      {
              $bs_class= ($type == "success") ? "alert-success" : "alert-danger";
              echo <<<alert
                  <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                      <strong class="me-3">$msg</strong> You should check in on some of those fields below.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              alert;
      }

      function uploadIamge($image,$folder)
      {
         $valid_name = ['image/jpeg', 'image/png', 'image/webp'];
         $img_mime = $image['type'];

         if(!in_array($img_mime,$valid_name)){
             return 'inv_img'; //invalid image mime or format
         }
         else if(($image['size']/(1024*1024))>5){
            return 'inv_size'; //invalid size
         }else{

          $ext= pathinfo($image['name'], PATHINFO_EXTENSION);
          $rname = 'IMG_'.random_int(11111,99999).".$ext";

          $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;

         if( move_uploaded_file($image['tmp_name'], $img_path)){
          return $rname;
         }
         else{
          return 'upd_failed';
         }
         }
      }

      function deleteImage($image, $folder)
      {
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
          return true;

        }else{
          return false;
        }
      }

      function uploadSVGIamge($image,$folder)
      {
         $valid_name = ['image/svg+xml'];
         $img_mime = $image['type'];

         if(!in_array($img_mime,$valid_name)){
             return 'inv_img'; //invalid image mime or format
         }
         else if(($image['size']/(1024*1024))>1){
            return 'inv_size'; //invalid size
         }else{

          $ext= pathinfo($image['name'], PATHINFO_EXTENSION);
          $rname = 'IMG_'.random_int(11111,99999).".$ext";

          $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;

         if( move_uploaded_file($image['tmp_name'], $img_path)){
          return $rname;
         }
         else{
          return 'upd_failed';
         }
         }
      }

      function uploadUserIamge($image)
      {
        $valid_name = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_name)){
            return 'inv_img'; //invalid image mime or format
        }
        else{

          $ext= pathinfo($image['name'], PATHINFO_EXTENSION);
          $rname = 'IMG_'.random_int(11111,99999).".jpeg";

          $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

          if($ext == 'png' || $ext == 'PNG'){
            $img = imagecreatefrompng($image['tmp_name']);
          }
          else if($ext == 'webp' || $ext == 'WEBP')
          {
            $img = imagecreatefromwebp($image['tmp_name']);
          }
          else if($ext == 'jpeg' || $ext == 'JPEG')
          {
            $img = imagecreatefromjpeg($image['tmp_name']);
          }
          else if($ext == 'jpg' || $ext == 'JPG')
          {
            $img = imagecreatefromjpeg($image['tmp_name']);
          }

          if(imagejpeg($img,$img_path,75)){
          return $rname;
          }
          else{
          return 'upd_failed';
          }
        }
      }


?>