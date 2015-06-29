<?php

require '../src/user.php';


$userId = null;
$userEmailId = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];
if (isset($_GET["userId"]))
    $userEmailId = $_GET["userEmailId"];

$infoArray = null;

if (User::addNewEmail($userId,$userEmailId))
{

$infoArray = array(
    'status' => "success",
    'message' => "Your request to update email ID has been received. "
);
}
else
{
   $infoArray = array(
    'status' => "failure",
    'message' => "Couldn't update your email. Contact administrator."
); 
}
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;
?>

