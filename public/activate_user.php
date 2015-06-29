
<?php

require '../src/user.php';

$userId = null;
$authenticationMethodId = null;
if (isset($_GET["userId"]))
    $userId = $_GET["userId"];
if (isset($_GET["authenticationMethodId"]))
    $authenticationMethodId = $_GET["authenticationMethodId"];

$message = "";
$status = "";

$activateUserStatus = User::activateUser($userId);

if ($activateUserStatus) {
    $status = "success";
    $message = "User has been successfully activated.";
    if ($authenticationMethodId == '0' || $authenticationMethodId == '2')
    {
        $token = User:: createToken();
        $add_token = User:: setTokenInDB($userId, $token);
        if ($add_token) {
            User:: setTokenInCookie($token);
        } 
        if ($authenticationMethodId == '2')
        User::setAuthTypeInCookie("google");
        
    } else if ($authenticationMethodId == '1')
    {
        User::setAuthTypeInCookie("facebook");
    }
} else {

    $status = "failure";
    $message = "Unexpected error while activating the user";
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

