<?php

    require('../admin/inc/db_config.php');
    require('../admin/inc/essential.php');
    require("../inc/sendgrid/sendgrid-php.php"); 

    date_default_timezone_set("Asia/Dhaka");

    if(isset($_POST['check_availability'])){

        $frm_data = filteration($_POST);
        $status="";
        $result="";

        // Checkin and Checkout Validation

        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($frm_data['check_in']);
        $checkout_date = new DateTime($frm_data['check_out']);

        if($checkin_date == $checkout_date){
            $status='check_in_out_equal';
            $result = json_encode(["status"=>$status]);
        }
        else if($checkout_date < $checkin_date){
            $status='check_out_earlier';
            $result = json_encode(["status"=>$status]);
        }
        else if( $checkin_date < $today_date){
            $status='check_in_earlier';
            $result = json_encode(["status"=>$status]);
        }

        // check availability if status is blank else return the error

        if($status!=''){
            echo $result;
        }
        else{
            session_start();
            $_SESSION['room']; 

            // run query to check if the room is available or not

            $count_days = date_diff($checkin_date,$checkout_date);

            $month = $count_days->m;
            $days = $count_days->d;
            $a_month = (30 - $days) + $days;
            $b_month = $a_month/30;
            $total_month = $month + $b_month;
            $payment = $_SESSION['room']['price'] * $total_month;

            $_SESSION['room']['payment'] = $payment; 
            $_SESSION['room']['available'] = true; 

            $result = json_encode(["status"=>'available', "days" =>$total_month, "payment"=>$payment]);
            echo $result;
        }


    }
?>