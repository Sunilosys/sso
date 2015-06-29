<?php

require '../src/user.php';


$userId = null;
$userEmailId = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];


$infoArray = null;

if (User::updateEmail($userId))
{

$infoArray = array(
    'status' => "success",
    'message' => "Your email has been successfully updated. Please login with new email address on next login. "
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

