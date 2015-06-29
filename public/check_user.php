<?php

require '../src/user.php';

$userEmailId = null;
if (isset($_GET["userEmailId"]))
    $userEmailId = $_GET["userEmailId"];

$authenticationMethod = "";
$status = "";

$userId = User::checkIfUserAlreadyExists($userEmailId, 0);

if ($userId == 0) {
    $userId = User::checkIfUserAlreadyExists($userEmailId, 1);
    if ($userId == 0) {
        $userId = User::checkIfUserAlreadyExists($userEmailId, 2);
        if ($userId == 0) {
            $authenticationMethod = "";
            $status = "Not Found";
        } else {
            $authenticationMethod = "google";
            $status = "Found";
        }
    } else {
        $authenticationMethod = "facebook";
        $status = "Found";
    }
} else {

    $authenticationMethod = "website";
    $status = "Found";
}


$infoArray = array(
    'status' => $status,
    'authenticationMethod' => $authenticationMethod,
    'userId' => $userId
);
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;
?>