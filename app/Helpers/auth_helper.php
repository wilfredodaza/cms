<?php

function ValidateReCaptcha($captcha){
  $ip = $_SERVER['REMOTE_ADDR'];
  $secretkey = env('keyReCaptcha');
  $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
  $attr = (object) json_decode($respuesta, TRUE);
  return $attr->success;
}