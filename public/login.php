<?php

require '../src/user.php';

$action = null;
$authenticationType = null;
$redirectUrl = null;
$failureUrl = null;
$loginUrl = null;
$userEmailId = null;
$userPwd = null;
$userFirstName = null;
$userLastName = null;
$address = null;
$screen = null;
$city = null;
$state = null;
$zip = null;
$country = null;
$zip = null;
$intersection = null;
$lat = null;
$lon = null;
$phone = null;
session_start();

////Get Request URL parameters
if (isset($_GET['action']))
    $action = $_GET['action'];

if (isset($_GET['authenticationType']))
    $authenticationType = $_GET['authenticationType'];

if (isset($_GET["successUrl"]))
    $successUrl = $_GET['successUrl'];

if (isset($_GET["failureUrl"]))
    $failureUrl = $_GET['failureUrl'];

if (isset($_GET["loginUrl"]))
    $loginUrl = $_GET['loginUrl'];

if (isset($_GET["userEmailId"]))
    $userEmailId = $_GET["userEmailId"];

if (isset($_GET["userPwd"]))
    $userPwd = $_GET["userPwd"];

if (isset($_GET["userFirstName"]))
    $userFirstName = $_GET["userFirstName"];

if (isset($_GET["userLastName"]))
    $userLastName = $_GET["userLastName"];


if (isset($_GET["address"]))
    $address = $_GET["address"];

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
if (isset($_GET["phone"]))
    $phone = $_GET["phone"];

if (isset($_GET["screen"]))
    $screen = $_GET["screen"];
//End

if ($action == 'login') {
    if ($authenticationType == "website") {
        
        $userId = User::checkLogin($userEmailId, $userPwd);

        if ($userId > 0) {
             if (isset($screen) && $screen == "change-email")
            {
                User::updateEmail($userId);
            }
            $jsonData = User::createSuccessResponse($userId);
            if (isset($_GET['callback']))
                echo $_GET['callback'] . '(' . $jsonData . ');';
            else
                echo '(' . $jsonData . ')';
           
            //header("location:" . $successUrl . "?status=success&user_id=" . $userId);
            exit;
        } else if ($userId == -1) {
//wrong password
            $jsonData = User::createFailureResponse("Incorrect Password");
            if (isset($_GET['callback']))
                echo $_GET['callback'] . '(' . $jsonData . ');';
            else
                echo '(' . $jsonData . ')';
            //header("location:" . $failureUrl . "?status=failure&errorMsg=IncorrectPwd&user_id=" . $userId);
            exit;
        }
        else {
            $jsonData = User::createFailureResponse('Incorrect Email or Password');
            if (isset($_GET['callback']))
                echo $_GET['callback'] . '(' . $jsonData . ');';
            else
                echo '(' . $jsonData . ')';
            //header("location:" . $failureUrl . "?status=failure&errorMsg=Unsuccessful&user_id=" . $userId);
            exit;
        }
    }
}

if ($action == "registration") {

    for ($i = 0; $i < 3; $i++) {
        $userId = User::checkIfUserAlreadyExists($userEmailId, $i);
        if ($userId > 0)
            break;
    }
    if ($userId == 0) {
        $userId = User::createUser(0, $userFirstName, $userLastName, $userEmailId, $userPwd, $phone);
        if ($userId > 0) {
            User::addAddressForUser($userId, $address, $city, $state, $country, $zip, $intersection, $lat, $lon);
            $token = User::createToken();
            User::setTokenInDB($userId, $token);
            User::setTokenInCookie($token);
            $jsonData = User::createSuccessResponse($userId);
            if (isset($_GET['callback']))
                echo $_GET['callback'] . '(' . $jsonData . ');';
            else
                echo '(' . $jsonData . ')';
            exit;
        }
    } else {
        $jsonData = User::createFailureResponse('There is already an account associated with this email address.');
        if (isset($_GET['callback']))
            echo $_GET['callback'] . '(' . $jsonData . ');';
        else
            echo '(' . $jsonData . ')';
        exit;
    }
}
?>
   

