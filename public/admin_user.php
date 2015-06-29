<?php

require '../src/user.php';

$authenticationType = null;
$userEmailId = null;
$userPwd = null;
$userFirstName = null;
$userLastName = null;
$address1 = null;
$address2 = null;
$city = null;
$state = null;
$zip = null;
$country = null;
$zip = null;
$intersection = null;
$lat = null;
$lon = null;

if (isset($_GET['authenticationType']))
    $authenticationType = $_GET['authenticationType'];


if (isset($_GET["userEmailId"]))
    $userEmailId = $_GET["userEmailId"];

if (isset($_GET["userPwd"]))
    $userPwd = $_GET["userPwd"];

if (isset($_GET["userFirstName"]))
    $userFirstName = $_GET["userFirstName"];

if (isset($_GET["userLastName"]))
    $userLastName = $_GET["userLastName"];

if (isset($_GET["address1"]))
    $address1 = $_GET["address1"];

if (isset($_GET["address2"]))
    $address2 = $_GET["address2"];

if (isset($_GET["city"]))
    $city = $_GET["city"];

if (isset($_GET["state"]))
    $state = $_GET["state"];

if (isset($_GET["country"]))
    $country = $_GET["country"];

if (isset($_GET["zip"]))
    $zip = $_GET["zip"];

if (isset($_GET["intersection"]))
    $intersection = $_GET["intersection"];

if (isset($_GET["lat"]))
    $lat = $_GET["lat"];

if (isset($_GET["lon"]))
    $lon = $_GET["lon"];

if (isset($authenticationType) && $authenticationType === 'facebook') {
    $userId = User::checkIfUserAlreadyExists($userEmailId, 1);
    if ($userId > 0) {
        User::updateUser($userId, 1, $userFirstName, $userLastName, $userEmailId, null, null);
        //User::updateAddressForUser($userId, $address1, $address2, $city, $state, $country, $zip, $intersection, $lat, $lon);
        User::setAuthTypeInCookie("facebook");
    } else if ($userId == 0) {
        $userId = User::createUser(1, $userFirstName, $userLastName, $userEmailId, null, null);
        if ($userId > 0) {
            User::addAddressForUser($userId, null, $city, $state, null, null, null, null, null);
            User::setAuthTypeInCookie("facebook");
        }
    }
    $jsonData = User::createSuccessResponse($userId);
    if (isset($_GET['callback']))
        echo $_GET['callback'] . '(' . $jsonData . ');';
    else
        echo '(' . $jsonData . ')';
    exit;
} else if (isset($authenticationType) && $authenticationType === 'google') {
    $userId = User::checkIfUserAlreadyExists($userEmailId, 2);
    if ($userId > 0) {
        User::updateUser($userId, 2, $userFirstName, $userLastName, $userEmailId, null, null);
        //User::updateAddressForUser($userId, $address1, $address2, $city, $state, $country, $zip, $intersection, $lat, $lon);
        User::setAuthTypeInCookie("google");
    } else if ($userId == 0) {
        $userId = User::createUser(2, $userFirstName, $userLastName, $userEmailId, null, null);
        if ($userId > 0) {
            User::addAddressForUser($userId, null, $city, $state, null, null, null, null, null);
            User::setAuthTypeInCookie("google");
        }
    }
    $token = User:: createToken();
    $add_token = User:: setTokenInDB($userId, $token);
    if ($add_token) {
        User:: setTokenInCookie($token);
    }
    $jsonData = User::createSuccessResponse($userId);
    if (isset($_GET['callback']))
        echo $_GET['callback'] . '(' . $jsonData . ');';
    else
        echo '(' . $jsonData . ')';
    exit;
}
?>
