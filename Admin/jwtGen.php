<?php
define('FIRSTKEY','/cYr34KlsGvTzrRiwPkkWxq3uDxfpOsKSErf5+FiH2w=');
define('SECONDKEY','pH0HWcOEQbAkOCY1r0cMjqkWxkCewBTASbepTYTbSSEB5pypK6WLdFt3FeoqK9lOt3/WOcsgh+Mct5RrSlO+7g==');
//This is a jwt generator and validator
function generator($data){
$first_key=base64_decode(FIRSTKEY);
$second_key=base64_decode(SECONDKEY);

$method="aes-256-cbc";
$iv_length=openssl_cipher_iv_length($method);
$iv=openssl_random_pseudo_bytes($iv_length);

$Encrypt_one=openssl_encrypt($data,$method,$first_key,OPENSSL_RAW_DATA,$iv);
$Encrypt_two=hash_hmac('sha256',$Encrypt_one,$second_key,TRUE);

$output=base64_encode($iv.$Encrypt_one.$Encrypt_two);
return $output;
}

function Extractor($input){
$first_key=base64_decode(FIRSTKEY);
$second_key=base64_decode(SECONDKEY);

$mix=base64_Decode($input);

$method="aes-256-cbc";
$iv_length=openssl_cipher_iv_length($method);

$iv=substr($mix,0,$iv_length);
$Encrypt_two=substr($mix,$iv_length,32);
$Encrypt_one=substr($mix,$iv_length+32);
//settype($Encrypt_two,"string");
$data=openssl_decrypt($Encrypt_one,$method,$first_key,OPENSSL_RAW_DATA,$iv);
$Encrypt_two_new=hash_hmac('sha256',$Encrypt_one,$second_key,TRUE);
//settype($Encrypt_two_new,"string");
if(hash_equals($Encrypt_two,$Encrypt_two_new)){
	return true;
}else{
	return false;
}
}
?>
