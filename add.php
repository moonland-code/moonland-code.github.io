<?php

include("validate.php");
 
$input = json_decode(file_get_contents('php://input'), true);

$user = validate($input['auth']);

$balance_file = "users/".$user['id']."/balance.json";

$balance = json_decode(file_get_contents($balance_file),true);

$balance['total'] += $input['add'];

file_put_contents($balance_file , json_encode($balance));

