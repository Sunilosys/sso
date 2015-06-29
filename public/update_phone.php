<?php

require '../src/user.php';


$userId = null;
$phone = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];


if (isset($_GET["phone"]))
    $phone = $_GET["phone"];


$infoArray = null;

if (User::updatePhone($userId,$phone))
{

$infoArray = array(
    'status' => "success",
    'message' => "Your phone has been successfully updated."
);
}
else
{
   $infoArray = array(
    'status' => "failure",
    'message' => "Couldn't update your phone. Contact administrator."
); 
}
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;
?>

