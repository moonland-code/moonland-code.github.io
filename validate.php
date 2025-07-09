<?php

 function validate($i) {

$bot_token = '7780958123:AAFE6pMSa6-DkV60RcGiriHYfcNQT8C1fzU';

$data_check_string = $i; // get from Telegram.WebAppData

$data_check_arr = explode('&', rawurldecode($data_check_string));
$needle = 'hash=';
$check_hash = FALSE;
foreach($data_check_arr AS &$val){
    if(substr($val, 0, strlen($needle)) === $needle){
        $check_hash = substr_replace($val, '', 0, strlen($needle));
        $val = NULL;
    }
}

$data_check_arr = array_filter($data_check_arr);
sort($data_check_arr);

$data_check_string = implode("\n", $data_check_arr);
$secret_key = hash_hmac('sha256', $bot_token, "WebAppData", true);
$hash = bin2hex(hash_hmac('sha256', $data_check_string, $secret_key, true) );

if(strcmp($hash, $check_hash) === 0){

    parse_str($i, $params);
    $user = $params['user'] ?? null;
             $user_decoded = json_decode($user,true);
            
             return ($user_decoded);
    
} else {
    return false;
}
     
 }