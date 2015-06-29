<?php

require '../src/user.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$authenticationType = "website";
$authenticationType = User::checkAuthCookie();

if (!isset($authenticationType))
    $authenticationType = "website";

if ($authenticationType == 'facebook')
    User::clearAuthTypeFromCookie("facebook");
else {
    $token = User::checkCookie();
    if (isset($token)) {
        $deleteToken = User::deleteTokenFromDB($token);
        User::clearTokenFromCookie("");
    }
     if ($authenticationType == 'google')
         User::clearAuthTypeFromCookie("google");
}
?>
