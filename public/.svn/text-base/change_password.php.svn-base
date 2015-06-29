
<?php

require '../src/user.php';

$userId = null;
$oldPassword = null;
$newPassword = null;

if (isset($_GET["userId"]))
    $userId = $_GET["userId"];

if (isset($_GET["oldPassword"]))
    $oldPassword = $_GET["oldPassword"];

if (isset($_GET["newPassword"]))
    $newPassword = $_GET["newPassword"];

$message = "";
$changePasswordStatus = "";
$status = "";

$changePasswordStatus = User::changePassword($userId, $oldPassword, $newPassword);

if ($changePasswordStatus) {
    $status = "success";
    $message = "Your password has been successfully changed.";
} else {

    $status = "failure";
    $message = "Password you entered is incorrect.";
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

