
<?php

require '../src/user.php';

$userId = null;
$newPassword = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];

if (isset($_GET["newPassword"]))
    $newPassword = $_GET["newPassword"];

$message = "";
$resetPasswordStatus = "";
$status = "";

$resetPasswordStatus = User::resetPassword($userId,$newPassword);

if ($resetPasswordStatus) {
    $status = "success";
    $message = "Your password has been successfully changed.";
} else {

    $status = "failure";
    $message = "Unknown error occurred. Please contact localjoe administrator.";
}


$infoArray = array(
    'status' => $status,
    'message' => $message
);
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;

?>

