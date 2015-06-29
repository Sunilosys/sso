<?php

require '../src/user.php';


$userId = null;

$address = null;

$city = null;
$state = null;
$zip = null;
$country = null;
$zip = null;
$intersection = null;
$lat = null;
$lon = null;


if (isset($_GET["userId"]))
    $userId = $_GET["userId"];


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


$infoArray = null;

if ( User::updateAddressForUser($userId, $address, $city, $state, $country, $zip, $intersection, $lat, $lon))
{

$infoArray = array(
    'status' => "success",
    'message' => "Your address has been successfully updated."
);
}
else
{
   $infoArray = array(
    'status' => "failure",
    'message' => "Couldn't update your address. Contact administrator."
); 
}
$jsonData = json_encode($infoArray);
if (isset($_GET['callback']))
    echo $_GET['callback'] . '(' . $jsonData . ');';
else
    echo '(' . $jsonData . ')';
exit;     

?>
