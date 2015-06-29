<?php

require '../src/user.php';
$userId = 0;
$token = User::checkCookie();
if (isset($token)) {
    $userId = User::checkToken($token);
}
if ($userId != 0) {
    $jsonData = User::createSuccessResponse($userId);
} else {
    $jsonData = User::createFailureResponse("Token does not exist.");
}

if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;
?>