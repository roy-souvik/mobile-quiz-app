<?php

class User
{
    public $id;
    public $promoter_id;
    public $name;
    public $email;
    public $social_no;
    public $phone_no;
    public $paytm;
    public $image;
    public $point;
    public $last_question;
    public $active;
    public $delete;
    public $bank_account_id;

    function __construct($data)
    {
      $this->id = $data['user_id'];
      $this->promoter_id = $data['promoter_id'];
      $this->name = $data['user_name'];
      $this->email = $data['user_email'];
      $this->social_no = $data['user_social_no'];
      $this->phone_no = $data['user_phone_no'];
      $this->paytm = $data['user_paytm'];
      $this->image = $data['user_image'];
      $this->point = $data['user_point'];
      $this->last_question = $data['user_last_question'];
      $this->active = $data['user_active'];
      $this->delete = $data['user_delete'];
      $this->bank_account_id = $data['bank_account_id'];
    }

}
