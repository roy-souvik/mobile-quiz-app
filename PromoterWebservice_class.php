<?php
require_once('constants.include.php');

class PromoterWebservice
{
/*============================ DB CONNECTION ===========================*/
     function dbconnenct()
     {
         if($_SERVER['HTTP_HOST'] == "localhost")
         {
           $host = "localhost";
           $promoter = "ntss";
           $pass = "eerning";
           $dbname = "promoter_competition";
         }else{
           $host = "localhost";
           $promoter = "ntss";
           $pass = "eerning";
           $dbname = "quiz_competition";
         }
         $conn = mysqli_connect($host, $promoter, $pass, $dbname) or die ("Error Connection: ".mysql_error());
         //$conn->query("SET NAMES 'utf8'");
         //$conn->query("SET CHARACTER SET utf8");
         //$conn->query("SET SESSION collation_connection = ’utf8_general_ci’");
         return $conn;
    }

/*============================ DB CONNECTION END =========================*/


/*=================================== LOGIN =============================*/
function log_in($req)
{
    $conn = $this->dbconnenct();
    $promoter['login'] = array();

    if(isset($req['promoter_email']) && isset($req['promoter_pass']))
    {

      $promoter_email = mysqli_real_escape_string($conn,trim($req['promoter_email']));
      $promoter_pass = mysqli_real_escape_string($conn,trim($req['promoter_pass']));

      if($promoter_email!="" || $promoter_pass!="")//CHECKING promoter E-MAIL FIELD BLANK OR NOT.
      {


        $availability_chk_sql = "SELECT * FROM `tbl_promoter` WHERE `promoter_email`='".$promoter_email."' AND `promoter_pass`='".$promoter_pass."'";
        $availability_result = $conn->query($availability_chk_sql);

        if($availability_result->num_rows > 0)//CHECKING THE DESIRED promoter AVAILABILITY.
        {

          $promoter_data="SELECT * FROM `tbl_promoter` WHERE `promoter_email`='".$promoter_email."'";
          $promoter_data_result =$conn->query($promoter_data);

          if($promoter_data_result->num_rows > 0)
          {

            $login_data_row = $promoter_data_result->fetch_assoc();
            $promoter_id = $login_data_row['promoter_id'];//STORE THE promoter ID OF THE REGISTERED promoter.

            $login_data_row['promoter_id'] = $login_data_row['promoter_id'];
            $login_data_row['promoter_name'] = $login_data_row['promoter_name'];
            $login_data_row['promoter_email'] = $login_data_row['promoter_email'];
            $login_data_row['promoter_phone'] = $login_data_row['promoter_phone'];
            $login_data_row['promoter_point'] = $login_data_row['promoter_point'];
            $promoter['login']["flag"]="true";
            $promoter['login']["message"]="Successfully Logged in.";
            $promoter['login']["promoter_details"]=$login_data_row;


          }
          else
          {
            $promoter['login']["flag"]="false";
            $promoter['login']["message"]="The account is deactivated.";
          }

        }
        else
        {
          $promoter['login']["flag"]="false";
          $promoter['login']["message"]="Invalid login credential.";
        }

      }
      else
      {
         $promoter['login']["flag"]="false";
         $promoter['login']["message"]="Email and Passwod fields cannot be empty";

      }

    }
    else
    {
      $promoter['login']["flag"]="false";
      $promoter['login']["message"]="Insufficient data! Need more parameter e.g. 'promoter_mail_id','promoter_pass'";
    }

    return $promoter['login'];
}
/*================================ LOGIN END ============================*/


/*=================================== USER LIST =============================*/
function user_list($req)
{
    $conn = $this->dbconnenct();
    $promoter['user_list'] = array();

    if(isset($req['promoter_email']))
    {

      $promoter_email = mysqli_real_escape_string($conn,trim($req['promoter_email']));

      if($promoter_email!="")//CHECKING promoter E-MAIL FIELD BLANK OR NOT.
      {


        $availability_chk_sql = "SELECT * FROM `tbl_promoter` WHERE `promoter_email`='".$promoter_email."'";
        $availability_result = $conn->query($availability_chk_sql);

        if($availability_result->num_rows > 0)//CHECKING THE DESIRED promoter AVAILABILITY.
        {

          $user_list_sql="SELECT `user_name`, `user_point` FROM `tbl_user` WHERE `promoter_id`='".$promoter_email."'";
          $user_list_result =$conn->query($user_list_sql);

          if($user_list_result->num_rows > 0)
          {
            $total_point = 0;
            $i=0;
            while($user_list = $user_list_result->fetch_assoc())
            {

              //$user_name      = $user_list['user_name'];
              $user_point     = $user_list['user_point'];
              $promoter_point = $user_point*10/100;
              $total_point = $total_point+$promoter_point;

              $promoter['user_list']["flag"]="true";
              $promoter['user_list']["message"]="All user found..";
              $promoter['user_list']["total_amount"]= (string)($total_point*0.10);
              $promoter['user_list']['users'][$i]['user_name'] = $user_list['user_name'];
              $promoter['user_list']['users'][$i]['user_point'] = $user_list['user_point'];
              $promoter['user_list']['users'][$i]['promoter_point'] = (string)$promoter_point;
              $i++;
            }

          }
          else
          {
            $promoter['user_list']["flag"]="false";
            $promoter['user_list']["message"]="The account is deactivated.";
          }

        }
        else
        {
          $promoter['user_list']["flag"]="false";
          $promoter['user_list']["message"]="Invalid user..";
        }

      }
      else
      {
         $promoter['user_list']["flag"]="false";
         $promoter['user_list']["message"]="Email cannot be empty";

      }

    }
    else
    {
      $promoter['user_list']["flag"]="false";
      $promoter['user_list']["message"]="Insufficient data! Need more parameter..";
    }

    return $promoter['user_list'];
}
/*================================ USER LIST END ============================*/



}
