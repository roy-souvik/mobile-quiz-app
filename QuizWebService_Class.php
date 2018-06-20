<?php
date_default_timezone_set('America/New_York');

class QuizWebService
{
      public $questionCategoryId;
      public $videoCategoryId;

      public function __construct()
      {
          $this->questionCategoryId = 1;
          $this->videoCategoryId = 2;
      }
/*============================ DB CONNECTION ===========================*/
     function dbconnenct()
     {
         if($_SERVER['HTTP_HOST'] == "localhost")
         {
           $host = "localhost";
           $user = "root";
           $pass = "password";
           $dbname = "quiz_competition";
         }else{
           $host = "localhost";
           $user = "ntss";
           $pass = "eerning";
           $dbname = "quiz_competition";
         }
         $conn = mysqli_connect($host, $user, $pass, $dbname) or die ("Error Connection: ".mysql_error());
         //$conn->query("SET NAMES 'utf8'");
         //$conn->query("SET CHARACTER SET utf8");
         //$conn->query("SET SESSION collation_connection = ’utf8_general_ci’");
         return $conn;
    }

/*============================ DB CONNECTION END =========================*/


/*============================ REGISTRATION =============================*/

function registration($req)
{
    $conn = $this->dbconnenct();
    $quiz['registration'] = array();
    //$quiz['question_array'] = array();

    if(
      isset($req['promoter_id']) &&
      isset($req['user_name']) &&
      isset($req['user_email']) &&
      isset($req['user_social_no']) &&
      isset($req['user_phone_no']) &&
      isset($req['user_paytm']) &&
      isset($req['user_bank']) &&
      isset($req['user_bank_ac']) &&
      isset($req['user_bank_ifsc']) &&
      isset($req['user_image'])
      )
    {
      $promoter_id = mysqli_real_escape_string($conn,trim($req['promoter_id']));
      $user_name = mysqli_real_escape_string($conn,trim($req['user_name']));
      $user_email = mysqli_real_escape_string($conn,trim($req['user_email']));
      $user_social_no = mysqli_real_escape_string($conn,trim($req['user_social_no']));
      $user_phone_no = mysqli_real_escape_string($conn,trim($req['user_phone_no']));
      $user_paytm = mysqli_real_escape_string($conn,trim($req['user_paytm']));
      $user_bank = mysqli_real_escape_string($conn,trim($req['user_bank']));
      $user_bank_ac = mysqli_real_escape_string($conn,trim($req['user_bank_ac']));
      $user_bank_ifsc = mysqli_real_escape_string($conn,trim($req['user_bank_ifsc']));
      $user_image = base64_decode($req['user_image']);
      //$user_image = mysqli_real_escape_string($conn,trim($req['user_image']));




      if($user_email!="" && $user_social_no!="")
      {
        $check_user_availability = "SELECT `user_id` FROM `tbl_user` WHERE `user_email`='".$user_email."'";
        $user_availability_result = $conn->query($check_user_availability);

        if($user_availability_result->num_rows > 0)
        {
          $quiz['registration']["flag"]="false";
          $quiz['registration']["message"]="e-mail already exist !! Try another id..";
        }
        else
        {
          $new_image_name = rand().".png";
          $dest_file = "IMAGE/USER/".$new_image_name;
          $upload_image = file_put_contents($dest_file, $user_image);

          $insert_user = "INSERT INTO tbl_user (promoter_id, user_name, user_email, user_social_no, user_phone_no, user_paytm, user_bank, user_bank_ac, user_bank_ifsc, user_image, user_point, 	user_last_question, user_active, user_delete) VALUES ('$promoter_id', '$user_name', '$user_email', '$user_social_no', '$user_phone_no', '$user_paytm', '$user_bank', '$user_bank_ac', '$user_bank_ifsc', '$new_image_name', 0, 0, 1, 0)";

          $insert_user_result = $conn->query($insert_user);

          if ($insert_user_result)
          {
              $user_data="SELECT * FROM `tbl_user` WHERE `user_email`='".$user_email."'";
              $user_data_result =$conn->query($user_data);


              if($user_data_result->num_rows > 0)
              {
                $registration_data_row = $user_data_result->fetch_assoc();
                $user_id = $registration_data_row['user_id'];//STORE THE USER ID OF THE REGISTERED USER.

                $registration_data_row['user_id'] = $registration_data_row['user_id'];
                $registration_data_row['promoter_id'] = $registration_data_row['promoter_id'];
                $registration_data_row['user_name'] = $registration_data_row['user_name'];
                $registration_data_row['user_email'] = $registration_data_row['user_email'];
                $registration_data_row['user_social_no'] = $registration_data_row['user_social_no'];
                $registration_data_row['user_phone_no'] = $registration_data_row['user_phone_no'];
                $registration_data_row['user_paytm'] = $registration_data_row['user_paytm'];
                $registration_data_row['user_bank'] = $registration_data_row['user_bank'];
                $registration_data_row['user_bank_ac'] = $registration_data_row['user_bank_ac'];
                $registration_data_row['user_bank_ifsc'] = $registration_data_row['user_bank_ifsc'];
                $registration_data_row['user_image'] ="http://www.nexttechsoftsolution.com/QUIZ/IMAGE/USER/". $registration_data_row['user_image'];
                $registration_data_row['user_point'] = $registration_data_row['user_point'];
                $quiz['registration']["flag"]="true";
                $quiz['registration']["message"]="Successfully registered.";
                $quiz['registration']["user_details"]=$registration_data_row;

                /*$i = 0;
                foreach ($test as $value)
                {
                  $quiz['registration']['question_id_array'][$i] = $value;
                  $i++;
                }*/


                $get_id = $registration_data_row['user_id'];
                $amount_sql="INSERT INTO tbl_user_amount (user_id, user_amount) VALUES ('$get_id', 0)";
                $get_amount =$conn->query($amount_sql);


              }
              else
              {
                $quiz['registration']["flag"]="false";
                $quiz['registration']["message"]="The account is deactivated.";
              }
          }
          else
          {

            $quiz['registration']["flag"]="false";
            $quiz['registration']["message"]="Registration failed..";

          }

        }

      }
      else
      {
         $quiz['registration']["flag"]="false";
         $quiz['registration']["message"]="Insufficient data! fields cannot be empty";

      }

    }
    else
    {
      $quiz['registration']["flag"]="false";
      $quiz['registration']["message"]="Insufficient data! Need more parameter";
    }

    return $quiz['registration'];

}

/*============================ REGISTRATION END =========================*/


/*=================================== LOGIN =============================*/
function log_in($req)
{
    $conn = $this->dbconnenct();
    $quiz['login'] = array();

    if(isset($req['user_email']))
    {

      $user_email = mysqli_real_escape_string($conn,trim($req['user_email']));

      if($user_email!="")//CHECKING USER E-MAIL FIELD BLANK OR NOT.
      {
        $chk_availability = "SELECT * FROM `tbl_user` WHERE `user_email`='".$user_email."'";//CHECKING THE DESIRED USER AVAILABILITY.
        $availability_result = $conn->query($chk_availability);

        if($availability_result->num_rows > 0)//CHECKING THE DESIRED USER AVAILABILITY.
        {

          $user_data="SELECT * FROM `tbl_user` WHERE `user_email`='".$user_email."'";
          $user_data_result =$conn->query($user_data);

          if($user_data_result->num_rows > 0)
          {

            //====================================RANDOM NO: ARRAY===================================
                    /*function nonRepeat($min,$max,$count)
                    {

                        //prevent function from hanging
                        //due to a request of more values than are possible
                        if($max - $min < $count)
                        {
                            return false;
                        }
                       $nonrepeatarray = array();
                       for($i = 0; $i <= $count; $i++)
                       {
                          $rand = rand($min,$max);

                          //ensure value isn't already in the array
                          //if it is, recalculate the rand until we
                          //find one that's not in the array
                          while(in_array($rand,$nonrepeatarray))
                          {
                            $rand = rand($min,$max);
                          }

                          //add it to the array
                          $nonrepeatarray[$i] = $rand;
                       }
                       return $nonrepeatarray;
                    }*/

                    //give it a test run
                    /*$test = nonRepeat(1,5,4);*/
                    /*echo "<pre>";
                    print_r($test);
                    echo "</pre>";*/

                    /*$i = 0;
                    foreach ($test as $value) {
                      $question_array[$i] = (string)$value;
                      $i++;
                    }*/
            //==================================RANDOM NO: ARAY END==================================



            $login_data_row = $user_data_result->fetch_assoc();
            $user_id = $login_data_row['user_id'];//STORE THE USER ID OF THE REGISTERED USER.

            $login_data_row['user_id'] = $login_data_row['user_id'];
            $login_data_row['user_name'] = $login_data_row['user_name'];
            $login_data_row['user_email'] = $login_data_row['user_email'];
            $login_data_row['user_social_no'] = $login_data_row['user_social_no'];
            $login_data_row['user_phone_no'] = $login_data_row['user_phone_no'];
            $login_data_row['user_paytm'] = $login_data_row['user_paytm'];
            $login_data_row['user_bank'] = $login_data_row['user_bank'];
            $login_data_row['user_bank_ac'] = $login_data_row['user_bank_ac'];
            $login_data_row['user_bank_ifsc'] = $login_data_row['user_bank_ifsc'];
            $login_data_row['user_image'] ="http://www.nexttechsoftsolution.com/QUIZ/IMAGE/USER/". $login_data_row['user_image'];
            $login_data_row['user_point'] = $login_data_row['user_point'];
            $quiz['login']["flag"]="true";
            $quiz['login']["message"]="Successfully registered.";
            $quiz['login']["user_details"]=$login_data_row;

            /*$i = 0;
            foreach ($test as $value)
            {
              $quiz['login']['question_id_array'][$i] = $value;
              $i++;
            }*/
          }
          else
          {
            $quiz['login']["flag"]="false";
            $quiz['login']["message"]="The account is deactivated.";
          }

        }
        else
        {
          $quiz['login']["flag"]="false";
          $quiz['login']["message"]="Invalid login credential.";
        }

      }
      else
      {
         $quiz['login']["flag"]="false";
         $quiz['login']["message"]="Insufficient data! 'user_mail_id','user_pass' fields cannot be empty";

      }

    }
    else
    {
      $quiz['login']["flag"]="false";
      $quiz['login']["message"]="Insufficient data! Need more parameter e.g. 'user_mail_id','user_pass'";
    }

    return $quiz['login'];
}
/*================================ LOGIN END ============================*/



/*----------------------------------------EDIT PROFILE------------------------------------------*/
    function edit_profile($req)
    {
        $conn = $this->dbconnenct();
        $quiz['edit_profile'] = array();

        /*-------------------------------IMAGE (if no image appere)----------------------*/
        if(
          isset($req['user_id']) &&
          isset($req['user_phone_no']) &&
          isset($req['user_paytm']) &&
          isset($req['user_bank']) &&
          isset($req['user_bank_ac']) &&
          isset($req['user_bank_ifsc']) &&
          isset($req['user_image'])
          )
        {
          $user_id = mysqli_real_escape_string($conn,trim($req['user_id']));
          $user_phone_no = mysqli_real_escape_string($conn,trim($req['user_phone_no']));
          $user_paytm = mysqli_real_escape_string($conn,trim($req['user_paytm']));
          $user_bank = mysqli_real_escape_string($conn,trim($req['user_bank']));
          $user_bank_ac = mysqli_real_escape_string($conn,trim($req['user_bank_ac']));
          $user_bank_ifsc = mysqli_real_escape_string($conn,trim($req['user_bank_ifsc']));
          $user_image = base64_decode($req['user_image']);


          if($user_id!="" && $user_phone_no!="" && $user_paytm!="" && $user_bank!="" && $user_bank_ac!="" && $user_bank_ifsc!="" && $user_image!="")
          {
            $availability_chk_sql = "SELECT `user_id` FROM `tbl_user` WHERE `user_id`='".$user_id."'";
            $availability_chk_result = $conn->query($availability_chk_sql);

            if($availability_chk_result->num_rows > 0)
            {
              $new_image_name = rand().".png";
                    $dest_file = "IMAGE/USER/".$new_image_name;
                    $upload_image = file_put_contents($dest_file, $user_image);

              $update_user_data_sql = "UPDATE tbl_user SET user_phone_no='$user_phone_no',user_paytm='$user_paytm',user_bank='$user_bank',user_bank_ac='$user_bank_ac',user_bank_ifsc='$user_bank_ifsc', user_image='$new_image_name' WHERE user_id='".$user_id."'";
              $update_user_data_result = $conn->query($update_user_data_sql);

              if ($update_user_data_result)
              {
                  $user_data_sql="SELECT * FROM `tbl_user` WHERE `user_id`='".$user_id."'";
                  $user_data_result =$conn->query($user_data_sql);

                  if($user_data_result->num_rows > 0)
                  {

                    $post_data_row = $user_data_result->fetch_assoc();
                    $post_data_row['user_id'] = $post_data_row['user_id'];
                    $post_data_row['promoter_id'] = $post_data_row['promoter_id'];
                    $post_data_row['user_name'] = $post_data_row['user_name'];
                    $post_data_row['user_email'] = $post_data_row['user_email'];
                    $post_data_row['user_social_no'] = $post_data_row['user_social_no'];
                    $post_data_row['user_phone_no'] = $post_data_row['user_phone_no'];
                    $post_data_row['user_paytm'] = $post_data_row['user_paytm'];
                    $post_data_row['user_bank'] = $post_data_row['user_bank'];
                    $post_data_row['user_bank_ac'] = $post_data_row['user_bank_ac'];
                    $post_data_row['user_bank_ifsc'] = $post_data_row['user_bank_ifsc'];
                    $post_data_row['user_profile_pic']="http://www.nexttechsoftsolution.com/QUIZ/IMAGE/USER/".$post_data_row['user_profile_pic'];
                    $quiz['edit_profile']["flag"]="true";
                    $quiz['edit_profile']["message"]="Successfully update user..";
                    $quiz['edit_profile']["Profile_details"]=$post_data_row;

                  }
                  else
                  {

                    $wing['edit_profile']["flag"]="false";
                    $wing['edit_profile']["message"]="User not found..";
                  }
              }
              else
              {

                $wing['edit_profile']["flag"]="false";
                $wing['edit_profile']["message"]="Failed to update..";

              }

            }
            else
            {
              $quiz['edit_profile']["flag"]="false";
              $quiz['edit_profile']["message"]="Usre does not exist !! Try valid id..";
            }

          }
          else
          {
             $quiz['edit_profile']["flag"]="false";
             $quiz['edit_profile']["message"]="fields cannot be empty";

          }

        }/*-------------------------------IMAGE (if no image appere) end ----------------------*/
        else
        {
          $quiz['edit_profile']["flag"]="false";
          $quiz['edit_profile']["message"]="Insufficient data!";
        }

        return $quiz['edit_profile'];
    }
/*-------------------EDIT PROFILE end----------------------------------------------------------*/





/*================================ QUS  ============================*/
function question($req)
{
    $conn = $this->dbconnenct();
    $quiz['question'] = array();
    //$quiz['question_detail'] = array();
    //$quiz['answer_list'] = array();

        if(isset($req['user_id']) && isset($req['lang']))
        {
          $user_id = $req['user_id'];
          $lang = mysqli_real_escape_string($conn,trim($req['lang']));

          $user_qus_id = "SELECT user_last_question FROM tbl_user WHERE user_id ='".$user_id."'";
          $get_qus_id = $conn->query($user_qus_id);
          $questions_id = $get_qus_id->fetch_assoc();
          $last = $questions_id['user_last_question'];


          if ($lang!="")
          {

                $qus_id = ++$last;
                $result = $conn->query("SELECT * FROM tbl_question");
                $row_cnt = $result->num_rows;
                if ($lang === 'en')
                {
                      if ($qus_id > $row_cnt)
                      {
                        $qus_id = 1;
                        $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = 0 WHERE `user_id` =$user_id";
                        $update_last_attempt_result = $conn->query($update_last_attempt);
                      }
                      $quiz['question']['flag'] = "true";
                      $quiz['question']['message'] = "English Question with options.";

                      $get_question = "SELECT `qus_id`,`qus_en_qustion`,`qus_en_option_1`,`qus_en_option_2`,`qus_en_option_3`,`qus_en_option_4` FROM `tbl_question` WHERE `qus_id`=$qus_id";
                      $get_question_result = $conn->query($get_question);

                      while($question_result_row = $get_question_result->fetch_assoc())
                      {
                        //$quiz['question']['question_detail'][$i] = $question_result_row;
                        //$quiz['question']['question_detail'] = $question_result_row;
                        $quiz['question']['question_detail']['id'] = $question_result_row['qus_id'];
                        $quiz['question']['question_detail']['question'] = $question_result_row['qus_en_qustion'];
                        $quiz['question']['question_detail']['option_1'] = $question_result_row['qus_en_option_1'];
                        $quiz['question']['question_detail']['option_2'] = $question_result_row['qus_en_option_2'];
                        $quiz['question']['question_detail']['option_3'] = $question_result_row['qus_en_option_3'];
                        $quiz['question']['question_detail']['option_4'] = $question_result_row['qus_en_option_4'];
                        //$i++;
                      }
                      $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = $qus_id WHERE `user_id` =$user_id";
                      $update_last_attempt_result = $conn->query($update_last_attempt);

                }
                elseif ($lang === 'bn')
                {
                  if ($qus_id > $row_cnt)
                  {
                    //echo "Limit cross...";
                    $qus_id = 1;
                    $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = 0 WHERE `user_id` =$user_id";
                    $update_last_attempt_result = $conn->query($update_last_attempt);
                  }


                      $quiz['question']['flag'] = "true";
                      $quiz['question']['message'] = "Bengali Question with options.";

                      $get_question = "SELECT `qus_id`,`qus_bn_qustion`,`qus_bn_option_1`,`qus_bn_option_2`,`qus_bn_option_3`,`qus_bn_option_4` FROM `tbl_question` WHERE `qus_id`=$qus_id";
                      $get_question_result = $conn->query($get_question);

                      while($question_result_row = $get_question_result->fetch_assoc())
                      {
                        //$quiz['question']['question_detail'][$i] = $question_result_row;
                        //$quiz['question']['question_detail'] = $question_result_row;
                        $quiz['question']['question_detail']['id'] = $question_result_row['qus_id'];
                        $quiz['question']['question_detail']['question'] = $question_result_row['qus_bn_qustion'];
                        $quiz['question']['question_detail']['option_1'] = $question_result_row['qus_bn_option_1'];
                        $quiz['question']['question_detail']['option_2'] = $question_result_row['qus_bn_option_2'];
                        $quiz['question']['question_detail']['option_3'] = $question_result_row['qus_bn_option_3'];
                        $quiz['question']['question_detail']['option_4'] = $question_result_row['qus_bn_option_4'];
                        //$i++;
                      }
                      $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = $qus_id WHERE `user_id` =$user_id";
                      $update_last_attempt_result = $conn->query($update_last_attempt);
                }
                /*elseif ($lang === 'hn')
                {
                  if ($qus_id > $row_cnt)
                  {
                    //echo "Limit cross...";
                    $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = 0 WHERE `user_id` =$user_id";
                    $update_last_attempt_result = $conn->query($update_last_attempt);
                    $quiz['question']['flag'] = "false";
                    $quiz['question']['message'] = "All question end..";
                  }
                  else
                  {

                      $quiz['question']['flag'] = "true";
                      $quiz['question']['message'] = "Bengali Question with options.";

                      $get_question = "SELECT `qus_id`,`qus_hn_qustion`,`qus_hn_option_1`,`qus_hn_option_2`,`qus_hn_option_3`,`qus_hn_option_4` FROM `tbl_question` WHERE `qus_id`=$qus_id";
                      $get_question_result = $conn->query($get_question);

                      while($question_result_row = $get_question_result->fetch_assoc())
                      {
                        //$quiz['question']['question_detail'][$i] = $question_result_row;
                        $quiz['question']['question_detail'] = $question_result_row;
                        //$i++;
                      }
                      $update_last_attempt = "UPDATE `tbl_user` SET `user_last_question` = $qus_id WHERE `user_id` =$user_id";
                      $update_last_attempt_result = $conn->query($update_last_attempt);

                  }
                }*/
                else
                {
                  $quiz['question']["flag"]="false";
                  $quiz['question']["message"]="Un recognized Language...";
                }

            }

            else
            {
              $quiz['question']["flag"]="false";
              $quiz['question']["message"]="User prefferd Language not defined...";
            }

        }
        else
        {
            $quiz['question']["flag"]="false";
            $quiz['question']["message"]="Insufficient Data...";
        }

  return $quiz['question'];

}

/*================================ QUS END ============================*/

/*================================ ANSWER  ============================*/
function answer($req)
{
    $conn = $this->dbconnenct();
    $quiz['answer'] = array();

        if(isset($req['user_id']) && isset($req['qus_id']) && isset($req['ans_string']) && isset($req['lang']))
        {
          $user_id    = $req['user_id'];
          $qus_id     = $req['qus_id'];
          $ans_string = mysqli_real_escape_string($conn,trim($req['ans_string']));
          $lang = mysqli_real_escape_string($conn,trim($req['lang']));

          if ($user_id!="" && $qus_id!="" /*&& $ans_string!=""*/  && $lang!="")
          {
            $scoreData = [
              'user_id' => intval($user_id),
              'question_id' => intval($qus_id),
              'ans_string' => $ans_string,
              'question_language' => $lang
            ];

              if ($lang === 'en')
              {
                $answer_sql = "SELECT `qus_en_right_ans` FROM `tbl_question` WHERE `qus_id` = $qus_id";
                $get_answer = $conn->query($answer_sql);

                if ($get_answer->num_rows > 0)
                {
                  $answer = $get_answer->fetch_assoc();
                  $answer = $answer['qus_en_right_ans'];
                  if (strcmp($ans_string, $answer) !== 0)
                  {
                      //echo "Answer not matched...";
                      $get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                      $user_point_result = $conn->query($get_user_point);
                        if ($user_point_result->num_rows > 0)
                        {
                          $user_point = $user_point_result->fetch_assoc();
                          $user_point = $user_point['user_point'];
                          $user_point = $user_point-5;

                          $update_user_point = "UPDATE `tbl_user` SET `user_point` = $user_point WHERE `user_id` =$user_id";
                          $update_user_point_result = $conn->query($update_user_point);

                          $scoreData['answer_matched'] = 0;
                          $scoreData['score'] = 5;

                          $this->addScore($scoreData, $this->questionCategoryId);

                          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                          $updated_point_result = $conn->query($get_updated_point);
                              if ($updated_point_result->num_rows > 0)
                              {
                                $updated_point = $updated_point_result->fetch_assoc();
                                $updated_point = $updated_point['user_point'];

                                $quiz['answer']["flag"]="true";
                                $quiz['answer']["message"]="Wrong answer...";
                                $quiz['answer']["ans"]="false";
                                $quiz['answer']["updated_point"]= $updated_point;

                                $updated_amount = $updated_point/10;
                                $actual_amount = floatval($updated_amount*0.50);
                                $update_user_amount_sql = "UPDATE tbl_user_amount SET user_amount = $actual_amount WHERE user_id = $user_id";
                                $updated_user_amount_result = $conn->query($update_user_amount_sql);
                              }
                        }
                  }
                  else
                  {
                    //echo "Answer matched...";
                    $get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                      $user_point_result = $conn->query($get_user_point);
                        if ($user_point_result->num_rows > 0)
                        {
                          $user_point = $user_point_result->fetch_assoc();
                          $user_point = $user_point['user_point'];
                          $user_point = $user_point+10;

                          $update_user_point = "UPDATE `tbl_user` SET `user_point` = $user_point WHERE `user_id` =$user_id";
                          $update_user_point_result = $conn->query($update_user_point);

                          $scoreData['answer_matched'] = 1;
                          $scoreData['score'] = 10;

                          $this->addScore($scoreData, $this->questionCategoryId);

                          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                          $updated_point_result = $conn->query($get_updated_point);
                              if ($updated_point_result->num_rows > 0)
                              {
                                $updated_point = $updated_point_result->fetch_assoc();
                                $updated_point = $updated_point['user_point'];

                                $quiz['answer']["flag"]="true";
                                $quiz['answer']["message"]="Right answer...";
                                $quiz['answer']["ans"]="true";
                                $quiz['answer']["updated_point"]= $updated_point;

                                $updated_amount = $updated_point/10;
                                $actual_amount = floatval($updated_amount*0.50);
                                $update_user_amount_sql = "UPDATE tbl_user_amount SET user_amount = $actual_amount WHERE user_id = $user_id";
                                $updated_user_amount_result = $conn->query($update_user_amount_sql);
                              }
                        }
                  }

                }
              }

              elseif ($lang === 'bn')
              {
                $answer_sql = "SELECT `qus_bn_right_ans` FROM `tbl_question` WHERE `qus_id` = $qus_id";
                $get_answer = $conn->query($answer_sql);

                if ($get_answer->num_rows > 0)
                {
                  $answer = $get_answer->fetch_assoc();
                  $answer = $answer['qus_bn_right_ans'];
                  if (strcmp($ans_string, $answer) !== 0)//IF THE ANSWER IS NOT MATCHED
                  {
                      //echo "Answer not matched...";
                      $get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                      $user_point_result = $conn->query($get_user_point);
                        if ($user_point_result->num_rows > 0)
                        {
                          $user_point = $user_point_result->fetch_assoc();
                          $user_point = $user_point['user_point'];
                          $user_point = $user_point-5;

                          $update_user_point = "UPDATE `tbl_user` SET `user_point` = $user_point WHERE `user_id` =$user_id";
                          $update_user_point_result = $conn->query($update_user_point);

                          $scoreData['answer_matched'] = 0;
                          $scoreData['score'] = 5;

                          $this->addScore($scoreData, $this->questionCategoryId);

                          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                          $updated_point_result = $conn->query($get_updated_point);
                              if ($updated_point_result->num_rows > 0)
                              {
                                $updated_point = $updated_point_result->fetch_assoc();
                                $updated_point = $updated_point['user_point'];

                                $quiz['answer']["flag"]="true";
                                $quiz['answer']["message"]="Wrong answer...";
                                $quiz['answer']["ans"]="false";
                                $quiz['answer']["updated_point"]= $updated_point;

                                $updated_amount = $updated_point/10;
                                $actual_amount = floatval($updated_amount*0.50);
                                $update_user_amount_sql = "UPDATE tbl_user_amount SET user_amount = $actual_amount WHERE user_id = $user_id";
                                $updated_user_amount_result = $conn->query($update_user_amount_sql);
                              }
                        }
                  }
                  else
                  {
                    //echo "Answer matched...";
                    $get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                      $user_point_result = $conn->query($get_user_point);
                        if ($user_point_result->num_rows > 0)
                        {
                          $user_point = $user_point_result->fetch_assoc();
                          $user_point = $user_point['user_point'];
                          $user_point = $user_point+10;

                          $update_user_point = "UPDATE `tbl_user` SET `user_point` = $user_point WHERE `user_id` =$user_id";
                          $update_user_point_result = $conn->query($update_user_point);

                          $scoreData['answer_matched'] = 1;
                          $scoreData['score'] = 10;

                          $this->addScore($scoreData, $this->questionCategoryId);

                          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                          $updated_point_result = $conn->query($get_updated_point);
                              if ($updated_point_result->num_rows > 0)
                              {
                                $updated_point = $updated_point_result->fetch_assoc();
                                $updated_point = $updated_point['user_point'];

                                $quiz['answer']["flag"]="true";
                                $quiz['answer']["message"]="Right answer...";
                                $quiz['answer']["ans"]="true";
                                $quiz['answer']["updated_point"]= $updated_point;

                                $updated_amount = $updated_point/10;
                                $actual_amount = floatval($updated_amount*0.50);
                                $update_user_amount_sql = "UPDATE tbl_user_amount SET user_amount = $actual_amount WHERE user_id = $user_id";
                                $updated_user_amount_result = $conn->query($update_user_amount_sql);
                              }
                        }
                  }

                }
              }
          }
          else
          {
            $quiz['answer']["flag"]="false";
            $quiz['answer']["message"]="Parameter can't be empty...";
          }
        }
        else
        {
            $quiz['answer']["flag"]="false";
            $quiz['answer']["message"]="Insufficient Data...";
        }

  return $quiz['answer'];

}

/*================================ ANSWER END ============================*/

/*================================ VIDEO ============================*/
function video($req)
{
	$conn = $this->dbconnenct();
	$quiz['video'] = array();

	if (isset($req['user_id']) && isset($req['type']) && isset($req['watch']))
	{
		$user_id = mysqli_real_escape_string($conn, trim($req['user_id']));
		$type = mysqli_real_escape_string($conn, trim($req['type']));
		$watch = mysqli_real_escape_string($conn, trim($req['watch']));

		if ($user_id!="" && $type!="" && $watch!="")
		{
			if ($type === 'skip')
			{
				if($watch === 'true')
				{
					$quiz['video']['flag'] = "true";
					$quiz['video']['message'] = "Player watch complete video..";
					$quiz['video']['user']['user_id'] = $user_id;
					$quiz['video']['user']['complete'] = 'true';
					$quiz['video']['user']['next'] = 'true';
				}
				elseif ($watch === 'false')
				{
					$quiz['video']['flag'] = "true";
					$quiz['video']['message'] = "Player did not watch complete video..";
					$quiz['video']['user']['user_id'] = $user_id;
					$quiz['video']['user']['complete'] = 'false';
					$quiz['video']['user']['next'] = 'false';

				}
			}
			elseif ($type === 'ignore')
			{
				if($watch === 'true')
				{
					$get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                    $user_point_result = $conn->query($get_user_point);
                        if ($user_point_result->num_rows > 0)
                        {
                          $user_point = $user_point_result->fetch_assoc();
                          $user_point = $user_point['user_point'];
                          $user_point = $user_point+5;

                          $update_user_point = "UPDATE `tbl_user` SET `user_point` = $user_point WHERE `user_id` =$user_id";
                          $update_user_point_result = $conn->query($update_user_point);

                          $scoreData = [
                            'user_id' => intval($user_id),
                            'score' => 5
                          ];
                          $this->addScore($scoreData, $this->videoCategoryId);

                          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
                          $updated_point_result = $conn->query($get_updated_point);

                          if ($updated_point_result->num_rows > 0)
                          {
                            $updated_point = $updated_point_result->fetch_assoc();
                            $updated_point = $updated_point['user_point'];

                            $quiz['video']['flag'] = "true";
              							$quiz['video']['message'] = "Player watch complete video..";
              							$quiz['video']['user']['user_id'] = $user_id;
              							$quiz['video']['user']['updated_point'] = $updated_point;
              							$quiz['video']['user']['next'] = 'true';
                          }
                        }
				}

				if ($watch === 'false') {
          $get_updated_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
          $updated_point_result = $conn->query($get_updated_point);

          if ($updated_point_result->num_rows > 0) {
            $updated_point = $updated_point_result->fetch_assoc();
            $updated_point = $updated_point['user_point'];

            $quiz['video']['flag'] = "true";
  					$quiz['video']['message'] = "Player did not watch complete video..";
  					$quiz['video']['user']['user_id'] = $user_id;
  					$quiz['video']['user']['updated_point'] = $updated_point;
  					$quiz['video']['user']['next'] = 'false';
          }
				}

			}
		} else {
			$quiz['video']['flag'] = "false";
			$quiz['video']['message'] = "Parameter cannot be empty..";
		}
	} else {
		$quiz['video']['flag'] = "false";
		$quiz['video']['message'] = "Insufficient Data. USER ID, TYPE, WATCH";
	}

	return $quiz['video'];
}


/*================================ VIDEO END ============================*/


/*================================ POINT ============================*/

function point($req)
{
  $conn = $this->dbconnenct();
  $quiz['point'] = array();

  if (isset($req['user_id']))
  {

    $user_id = mysqli_real_escape_string($conn, trim($req['user_id']));
    if ($user_id!="")
    {

      $get_user_point = "SELECT `user_point` FROM `tbl_user` WHERE `user_id` = $user_id";
      $user_point_result = $conn->query($get_user_point);
        if ($user_point_result->num_rows > 0)
        {

          $user_point = $user_point_result->fetch_assoc();
          //$user_point = $user_point['user_point'];

          $quiz['point']['flag'] = "true";
          $quiz['point']['message'] = "Player Points found successfully...";
          $quiz['point']['user_point'] = $user_point['user_point'];
        }

    }
    else
    {
      $quiz['point']['flag'] = "false";
      $quiz['point']['message'] = "USER ID Can't be blank...";
    }
  }else
  {
    $quiz['point']['flag'] = "false";
    $quiz['point']['message'] = "Insufficient Data. USER ID..";
  }

  return $quiz['point'];

}
/*================================ POINT END ============================*/


/*================================ VERSION ============================*/
function version($req){
    $conn = $this->dbconnenct();
    $quiz['version'] = array();
    if (isset($req['version_details']))
    {
        $version_details = mysqli_real_escape_string($conn, trim($req['version_details']));
        if ($version_details!="")
        {
          $get_version = "SELECT version_name FROM tbl_version";
          $version_result = $conn->query($get_version);
          if ($version_result->num_rows > 0)
          {
            $version = $version_result->fetch_assoc();
            $version = $version['version_name'];

            if ($version === $version_details)
            {
              $quiz['version']['flag'] = "true";
            }
            else
            {
              $quiz['version']['flag'] = "false";
              $quiz['version']['message'] = "Your app is not up to date. Please update the app to continue..";
            }
          }
        }
        else
        {
          $quiz['version']['flag'] = "false";
          $quiz['version']['message'] = "Version Can't be blank...";
        }

    }else
    {
      $quiz['version']['flag'] = "false";
      $quiz['version']['message'] = "Insufficient Data. App Version";
    }

    return $quiz['version'];
}
/*================================ VERSION END ============================*/

/*================================ WITHDRAWAL ===============================*/

function withdrawal($req)
{

  $conn = $this->dbconnenct();
  $quiz['withdrawal'] = array();

  if (isset($req['user_id']) && isset($req['type']))
  {
      $user_id = mysqli_real_escape_string($conn, trim($req['user_id']));//GET THE USER ID.
      $type = mysqli_real_escape_string($conn, trim($req['type']));//GET THE WITHDRAL TYPE (RECHARGE or
                                                                  //PAYTM or BANK.

      if ($type === 'recharge')// CHECK IF THE WITHDRAL TYPE IS 'RECHARGE'
      {

          $request_date = date('Y-m-d');//STORE THE CURRENT REQUESTED DATE BY USER

          $request_date_formated = new DateTime($request_date);//CONVERT THE
                                                              // '$request_date' INTO 'DATE TIME' TYPE

          //$last_request_date = "SELECT transaction_request_date FROM tbl_transaction WHERE user_id = $user_id";//GET THE LAST WITHDRAL REQUEST DATE ASSOCIATED WITH THE USER ID.

          $last_request_date = "SELECT transaction_request_date FROM tbl_transaction WHERE user_id = $user_id ORDER BY transaction_id DESC LIMIT 1";//GET THE LAST WITHDRAL REQUEST DATE ASSOCIATED WITH THE USER ID.

          $last_request_date = $conn->query($last_request_date);
          if ($last_request_date->num_rows > 0)
          {
            $last_request_date = $last_request_date->fetch_assoc();
            $last_request_date = $last_request_date['transaction_request_date'];
            $last_request_date = new DateTime($last_request_date);//CONVERT
                                                                //LAST REQUEST DATE INTO DATE TYPE.

            $day_difference = $last_request_date->diff($request_date_formated)->format("%a");//CALCULATE THE DIFFERENCE BETWEEN
                                                          //LAST REQUEST DATE and NEW REQUEST
                                                          //DATE.
            /*$day_difference = date_diff($last_request_date,$request_date_formated);
            echo $day_difference->format('%d');echo "<br>";*/

            if ($day_difference < 15)
            {

              $remaining_day = 15 - $day_difference;

              $quiz['withdrawal']['flag'] = "false";
              $quiz['withdrawal']['message'] = "You would not able to Withdral request before 15 days.. ".$remaining_day." days   remaining..";
            }
            else
            {

              $get_phone = "SELECT user_phone_no FROM tbl_user WHERE user_id = $user_id";
              $get_phone_result = $conn->query($get_phone);

              if ($get_phone_result->num_rows > 0)
              {
                while ($value = $get_phone_result->fetch_assoc())
                {
                  //$get_phone = $value['user_phone_no'];
                  $quiz['withdrawal']['flag'] = "true";
                  $quiz['withdrawal']['phone_no'] = $value['user_phone_no'];
                }
              }
              else
              {
                $quiz['withdrawal']['flag'] = "true";
                $quiz['withdrawal']['message'] = "Phone no found..";
              }

              /*$transaction_sql = "INSERT INTO tbl_transaction (user_id, transaction_request, transaction_request_date, transaction_action_date, transaction_request_amount, transaction_status) VALUES ('$user_id', '$type', '$request_date', 0000-00-00, '$amount', 'in-process')";//STORE SOME INFORMATION INTO 'TRANSACTION' TABLE
                                        //ASSOCIATED WITH THE
                                        //USER.
              $transaction_sql = $conn->query($transaction_sql);

              $quiz['withdrawal']['flag'] = "true";
              $quiz['withdrawal']['message'] = "Congratulations..";*/


            }
          }
          else
          {
            $quiz['withdrawal']['flag'] = "false";
            $quiz['withdrawal']['message'] = "No transaction done yet by this User..";
          }

      }
      elseif ($type === 'paytm')
      {
        echo "paytm";
      }
      elseif ($type === 'bank')
      {
        echo "bank";
      }

  }
  else
  {
    $quiz['withdrawal']['flag'] = "false";
    $quiz['withdrawal']['message'] = "Insufficient Data...";
  }

  return $quiz['withdrawal'];

}
/*=================================WITHDRAWAL END =============================*/


/*=================================RECHARGE WITHDRAWAL=============================*/
function recharge_withdrawal($req)
{
  $conn = $this->dbconnenct();
  $quiz['recharge_withdrawal'] = array();
  $transaction = array();

  if (isset($req['user_id']) && isset($req['phone_no']) && isset($req['phone_operator']) && isset($req['amount']) && isset($req['comment']))
  {
    $user_id = mysqli_real_escape_string($conn, trim($req['user_id']));//GET THE USER PHONE NO:.
    $phone_no = mysqli_real_escape_string($conn, trim($req['phone_no']));//GET THE USER PHONE NO:.
    $phone_operator = mysqli_real_escape_string($conn, trim($req['phone_operator']));//GET THE USER PHONE OPERATOR.
    $amount   = mysqli_real_escape_string($conn, trim($req['amount']));//GET THE USER REQUESTED AMOUNT.
    $comment  = mysqli_real_escape_string($conn, trim($req['comment']));//GET THE USER REQUESTED COMMENT.

    if ($user_id!="" && $phone_no!="" && $phone_operator!="" && $amount!="")
    {
          $cons_amount = "SELECT amount FROM tbl_constant WHERE type = 'recharge'";// GET THE CONSTANT/MINIMUM
                                                                                  //AMOUNT FOR RECHARGE.
          $cons_amount_result = $conn->query($cons_amount);

        if ($cons_amount_result->num_rows > 0)
        {
          $const = $cons_amount_result->fetch_assoc();
          $const = $const['amount'];//STORE THE CONSTANT AMOUNT
                                                                            //FOR RECHARGE.
          $get_user_amount = "SELECT user_amount FROM tbl_user_amount WHERE user_id = $user_id";//GET
                                                                                                //THE USER
                                                                                                //AVAILABLE
                                                                                                //BALANCE.
          $get_user_amount = $conn->query($get_user_amount);
          if ($get_user_amount->num_rows > 0)
          {
              $user_amount = $get_user_amount->fetch_assoc();//
              $user_amount = $user_amount['user_amount'];//STORE THE USER
                                                                                        //AVAILABLE
                                                                                        //BALANCE.
              if ($amount > $user_amount)//CHECK IF THE USER REQUESTED AMOUNT IS MORE THAN
                                        // BALANCE AMOUNT OR NOT.
              {
                  $quiz['recharge_withdrawal']['flag'] = "false";
                  $quiz['recharge_withdrawal']['message'] = "Request amount is not possible.. Oopss..";
              }
              elseif ($amount < $const)//CHECK IF THE USER REQUESTED AMOUNT IS LESS THAN
                                      // CONSTANT or PRESET AMOUNT OR NOT.
              {
                  $quiz['recharge_withdrawal']['flag'] = "false";
                  $quiz['recharge_withdrawal']['message'] = "You have to request atleast".$const."bucks..";
              }
              else
              {

                $request_date = date('Y-m-d');//STORE THE CURRENT REQUESTED DATE BY USER
                $request_date_formated = new DateTime($request_date);//CONVERT THE
                                                                    // '$request_date' INTO 'DATE TIME' TYPE

                $transaction_sql = "INSERT INTO tbl_transaction (
                user_id,
                transaction_request,
                recharge_no,
                recharge_operator,
                transaction_request_date,
                transaction_action_date,
                transaction_request_amount,
                transaction_status)
                VALUES (
                '$user_id',
                'recharge',
                '$phone_no',
                '$phone_operator',
                '$request_date',
                0000-00-00,
                '$amount',
                'in-process')";//STORE SOME INFORMATION INTO 'TRANSACTION' TABLE
                                //ASSOCIATED WITH THE USER.

                $transaction_sql = $conn->query($transaction_sql);

                $updated_transaction_list_sql = "SELECT * FROM tbl_transaction WHERE user_id = $user_id ORDER BY transaction_id DESC";//GET THE ALL TRANSACTION REQUEST LIST ASSOCIATED WITH THE USER.
                $run_sql = $conn->query($updated_transaction_list_sql);//RUN THE QUERY

                if ($run_sql->num_rows > 0)
                {
                  $cnt = 0;
                  while ( $values = $run_sql->fetch_assoc())
                  {
                    $transaction[$cnt]['transaction_id'] = $values['transaction_id'];
                    $transaction[$cnt]['transaction_request'] = $values['transaction_request'];
                    $transaction[$cnt]['recharge_no'] = $values['recharge_no'];
                    $transaction[$cnt]['recharge_operator'] = $values['recharge_operator'];
                    $transaction[$cnt]['transaction_request_date'] = $values['transaction_request_date'];
                    $transaction[$cnt]['transaction_action_date'] = $values['transaction_action_date'];
                    $transaction[$cnt]['transaction_request_amount'] = $values['transaction_request_amount'];
                    $transaction[$cnt]['comment'] = $values['comment'];

                    $transaction[$cnt]['admin_comment'] = $values['admin_comment'];
                    $transaction[$cnt]['transaction_status'] = $values['transaction_status'];

                    $cnt++;
                  }

                }

                $quiz['recharge_withdrawal']['flag'] = "true";
                $quiz['recharge_withdrawal']['message'] = "Your request is in progress..";
                $quiz['recharge_withdrawal']['transactions'] = $transaction;
              }
          }
        }
    }
    else
    {
      $quiz['recharge_withdrawal']['flag'] = "false";
      $quiz['recharge_withdrawal']['message'] = "Phone No: , Operator , Amount Field must be filled...";

    }
  }
  else
  {
    $quiz['recharge_withdrawal']['flag'] = "false";
    $quiz['recharge_withdrawal']['message'] = "Insufficient Parameter";
  }
  return $quiz['recharge_withdrawal'];
}

/*=================================RECHARGE WITHDRAWAL END=============================*/


/*================================= WALLET =============================*/
function wallet($req)
{

  $conn = $this->dbconnenct();
  $quiz['wallet'] = array();

  if (isset($req['user_id']))
  {
    $user_id = mysqli_real_escape_string($conn, trim($req['user_id']));

    if ($user_id!="")
    {
      $userAmount_sql = "SELECT user_amount FROM tbl_user_amount WHERE user_id = $user_id";
      $userAmount = $conn->query($userAmount_sql);
      if ($userAmount)
      {
        $userAmount = $userAmount->fetch_assoc();
        $userAmount = $userAmount['user_amount'];
        $sumRequest_sql = "SELECT sum(transaction_request_amount) as total FROM tbl_transaction WHERE user_id=$user_id";
        $sumRequest = $conn->query($sumRequest_sql);
        if ($sumRequest)
        {
          $sumRequest = $sumRequest->fetch_assoc();
          $sumRequest = $sumRequest['total'];
          $qBalance = $userAmount - $sumRequest;

          $quiz['wallet']['flag'] = "true";
          $quiz['wallet']['message'] = "Get user data";
          $quiz['wallet']['balance_detail']['balanceAmount'] = $userAmount;
          $quiz['wallet']['balance_detail']['requestAmount'] = $sumRequest;

          $transactionList = "SELECT transaction_id, transaction_request, recharge_no, recharge_operator, transaction_request_date, transaction_action_date, transaction_request_amount, transaction_status FROM tbl_transaction WHERE user_id=$user_id";
          $transactionList = $conn->query($transactionList);

          if ($transactionList)
          {
            $i = 0;
            while ($rows = $transactionList->fetch_assoc())
            {
              $quiz['wallet']['transaction_detail'][$i] = $rows;
              $i++;
            }
          }
        }
      }
    }
    else
    {
      $quiz['quiz']['flag'] = "false";
      $quiz['quiz']['message'] = "User ID can't be empty";
    }
  }
  else
  {
    $quiz['quiz']['flag'] = "false";
    $quiz['quiz']['message'] = "Insufficient Parameter";
  }
return $quiz['wallet'];
}

/*================================= WALLET END=============================*/

/*================================= TRANSCTION DETAILS=============================*/
function tarnsaction_details($req)
{

  $conn = $this->dbconnenct();
  $quiz['details'] = array();

  if (isset($req['transaction_id']))
  {
    $transaction_id = mysqli_real_escape_string($conn, trim($req['transaction_id']));

    if ($transaction_id!="")
    {
      $transactionType_sql = "SELECT transaction_request FROM tbl_transaction WHERE transaction_id = $transaction_id";
      $transactionType = $conn->query($transactionType_sql);
      if ($transactionType->num_rows > 0)
      {
        $transactionType = $transactionType->fetch_assoc();
        $transactionType = $transactionType['transaction_request'];

        $tarnsactionDetail_sql = "SELECT * FROM tbl_transaction WHERE transaction_id=$transaction_id";
        $tarnsactionDetail = $conn->query($tarnsactionDetail_sql);
        $tarnsactionDetail = $tarnsactionDetail->fetch_assoc();
        if ($transactionType === 'recharge')
        {

          $quiz['details']['flag'] = "true";
          $quiz['details']['message'] = "Get tarnsaction data";
          $quiz['details']['tarnsaction_details']['transaction_request'] = $tarnsactionDetail['transaction_request'];
          $quiz['details']['tarnsaction_details']['recharge_no'] = $tarnsactionDetail['recharge_no'];
          $quiz['details']['tarnsaction_details']['recharge_operator'] = $tarnsactionDetail['recharge_operator'];
          $quiz['details']['tarnsaction_details']['transaction_request_date'] = $tarnsactionDetail['transaction_request_date'];
          $quiz['details']['tarnsaction_details']['transaction_action_date'] = $tarnsactionDetail['transaction_action_date'];
          $quiz['details']['tarnsaction_details']['transaction_request_amount'] = $tarnsactionDetail['transaction_request_amount'];
          $quiz['details']['tarnsaction_details']['comment'] = $tarnsactionDetail['comment'];
          $quiz['details']['tarnsaction_details']['admin_comment'] = $tarnsactionDetail['admin_comment'];
          $quiz['details']['tarnsaction_details']['transaction_status'] = $tarnsactionDetail['transaction_status'];
        }
        elseif ($transactionType === 'bank')
        {
          $quiz['details']['flag'] = "true";
          $quiz['details']['message'] = "Get tarnsaction data";
          $quiz['details']['tarnsaction_details']['transaction_request'] = $tarnsactionDetail['transaction_request'];
          $quiz['details']['tarnsaction_details']['bank_holder_name'] = $tarnsactionDetail['bank_holder_name'];
          $quiz['details']['tarnsaction_details']['bank_name'] = $tarnsactionDetail['bank_name'];
          $quiz['details']['tarnsaction_details']['bank_acc_no'] = $tarnsactionDetail['bank_acc_no'];
          $quiz['details']['tarnsaction_details']['bank_ifsc'] = $tarnsactionDetail['bank_ifsc'];
          $quiz['details']['tarnsaction_details']['transaction_request_date'] = $tarnsactionDetail['transaction_request_date'];
          $quiz['details']['tarnsaction_details']['transaction_action_date'] = $tarnsactionDetail['transaction_action_date'];
          $quiz['details']['tarnsaction_details']['transaction_request_amount'] = $tarnsactionDetail['transaction_request_amount'];
          $quiz['details']['tarnsaction_details']['comment'] = $tarnsactionDetail['comment'];
          $quiz['details']['tarnsaction_details']['admin_comment'] = $tarnsactionDetail['admin_comment'];
          $quiz['details']['tarnsaction_details']['transaction_status'] = $tarnsactionDetail['transaction_status'];
        }
        elseif ($transactionType === 'paytm')
        {
          $quiz['details']['flag'] = "true";
          $quiz['details']['message'] = "Get tarnsaction data";
          $quiz['details']['tarnsaction_details']['transaction_request'] = $tarnsactionDetail['transaction_request'];
          $quiz['details']['tarnsaction_details']['paytm_id'] = $tarnsactionDetail['paytm_id'];
          $quiz['details']['tarnsaction_details']['transaction_request_date'] = $tarnsactionDetail['transaction_request_date'];
          $quiz['details']['tarnsaction_details']['transaction_action_date'] = $tarnsactionDetail['transaction_action_date'];
          $quiz['details']['tarnsaction_details']['transaction_request_amount'] = $tarnsactionDetail['transaction_request_amount'];
          $quiz['details']['tarnsaction_details']['comment'] = $tarnsactionDetail['comment'];
          $quiz['details']['tarnsaction_details']['admin_comment'] = $tarnsactionDetail['admin_comment'];
          $quiz['details']['tarnsaction_details']['transaction_status'] = $tarnsactionDetail['transaction_status'];
        }
      }
      else
      {
        $quiz['quiz']['flag'] = "false";
        $quiz['quiz']['message'] = "Payment request type is not recognizeable..";
      }
    }
    else
    {
      $quiz['quiz']['flag'] = "false";
      $quiz['quiz']['message'] = "User ID can't be empty";
    }
  }
  else
  {
    $quiz['quiz']['flag'] = "false";
    $quiz['quiz']['message'] = "Insufficient Parameter";
  }
return $quiz['details'];
}
/*================================= TRANSCTION DETAILS END=============================*/

  public function addScore($data, $scoreCategoryId)
  {
      $scoreTable = 'tbl_user_scores';
      $connection = $this->dbconnenct();

      if ($scoreCategoryId === $this->questionCategoryId) {
        $sql = "INSERT INTO `{$scoreTable}` (
          `user_id`, `score_category`, `question_id`, `score`, `ans_string`, `answer_matched`, `question_language`)
           VALUES ('{$data['user_id']}', '{$scoreCategoryId}', '{$data['question_id']}', '{$data['score']}', '{$data['ans_string']}', '{$data['answer_matched']}', '{$data['question_language']}')";
      }

      if ($scoreCategoryId === $this->videoCategoryId) {
        $sql = "INSERT INTO `{$scoreTable}` (
          `user_id`, `score_category`, `score`)
           VALUES ('{$data['user_id']}', '{$scoreCategoryId}', '{$data['score']}')";
      }

      return $connection->query($sql) ? $connection->insert_id : 0;
  }

}
