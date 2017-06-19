<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 21.05.17
 * Time: 18:08
 */
namespace Birthright\Core\Service;
class CaptchaService
{
 public function verifyCaptcha(&$notices, $captcha){
     $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . SECRET_KEY . '&response=' . $captcha);
     $responseData = json_decode($verifyResponse);
     if(!$responseData->success){
         $notices['captcha'] = 'Неправильная капча';
     }
 }
}