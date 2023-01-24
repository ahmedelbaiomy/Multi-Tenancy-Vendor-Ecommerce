<?php

namespace App\Http\Services;


use App\Models\UserVerification;

class VerificationOTP
{
    public function setVerificationCode($data)
    {
      $code=mt_rand(100000,999999);
      $data['otp_code'] = $code;
        UserVerification::whereNotNull('user_id')->where(['user_id'=> $data['user_id']])->delete();

      return UserVerification::create($data);
    }
}
