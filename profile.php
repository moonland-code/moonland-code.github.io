<?php

 include("validate.php");
 
 $input = json_decode(file_get_contents('php://input'), true);

 $user = validate($input['auth']);
 

 if ($user) {
     
     $directory = "users/".$user['id'];
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
        file_put_contents("$directory/balance.json", json_encode(["total"=>0]) );
    }
    
    file_put_contents("$directory/profile.json", json_encode($user) );
    file_put_contents("$directory/photo.jpg", file_get_contents($user['photo_url']) );
    
    $balance = json_decode(file_get_contents("$directory/balance.json"),true);
    $user["balance"] =  $balance['total'];

    echo json_encode($user);
     
 } else {
      echo json_encode(['error' => 'Invalid hash']);
 }
