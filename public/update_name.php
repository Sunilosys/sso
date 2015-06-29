<?php

require '../src/user.php';


$userId = null;
$userFirstName = null;
$userLastName = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];


if (isset($_GET["userFirstName"]))
    $userFirstName = $_GET["userFirstName"];

if (isset($_GET["userLastName"]))
    $userLastName = $_GET["userLastName"];
$infoArray = null;

if (User::updateName($userId,$userFirstName, $userLastName))
{

$infoArray = array(
    'status' => "success",
    'message' => "Your name has been successfully updated."
);
}
else
{
   $infoArray = array(
    'status' => "failure",
    'message' => "Couldn't update your name. Contact administrator."
); 
}
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;
?>

