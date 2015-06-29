<?php

require '../configs/config.php';

class User {
   
    public static function checkLogin($userEmailId, $password = null) {
        $connection = null;
        $userId = 0;
        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME) or die(mysql_error());
            $result = mysql_query("SELECT user_id,password FROM user_info WHERE email = '$userEmailId'")
                    or die(mysql_error());
            $check2 = mysql_num_rows($result);
            
            if ($check2 > 0) {
                $row = mysql_fetch_assoc($result);
                if ($password == $row['password']) {
                    $userId = $row['user_id'];
                    $token = User:: createToken();
                  
                    $add_token = User:: setTokenInDB($userId, $token);

                    if ($add_token) {
                        User:: setTokenInCookie($token);
                    } else {
                        $userId = -1;
                    }
                }
            }

            //mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }
        return $userId;
    }

    public static function checkIfUserAlreadyExists($email,$authenticationType) {
        $userId = 0;
        $connection = null;
        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME) or die(mysql_error());
            // checks if the user already exists
            if (!get_magic_quotes_gpc()) {

                $email = addslashes($email);
            }

            $check = mysql_query("SELECT user_id FROM user_info WHERE email = '".$email."' and authentication_method_id='".$authenticationType."'" )
                    or die(mysql_error());

            $check2 = mysql_num_rows($check);
            if ($check2 > 0) {
                $row = mysql_fetch_assoc($check);
                $userId = $row['user_id'];
            }
 
        } catch (Exception $ex) {
               
            mysql_close($connection);
        }
        return $userId;
    }

    public static function createUser($authenticationMethodId, $firstName, $lastName, $email, $password = null,$phone=null) {

        $userId = 0;
        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);
            // checks if the user already exists
            if (!get_magic_quotes_gpc()) {

                $email = addslashes($email);
            }

            $check = mysql_query("SELECT user_id FROM user_info WHERE email = '$email'")
                    or die(mysql_error());

            $check2 = mysql_num_rows($check);
      
            if ($check2 == 0) {
                // Create user

                $insert = "INSERT INTO user_info (authentication_method_id, first_name,last_name,email,password,phone,date_created,date_updated)

 			VALUES ('" . $authenticationMethodId . "', '" . $firstName . "','" . $lastName . "','" . $email . "','" . $password . "','" . $phone . "','" . $mysqldate . "','" . $mysqldate . "')";

               
                $add_member = mysql_query($insert);

                if ($add_member) {
                    //Get the user id of the user
                    $result = mysql_query("SELECT user_id FROM user_info WHERE email = '$email'");
                    $row = mysql_fetch_assoc($result);
                    $userId = $row['user_id'];
                    return $userId;
                }
            } else {
                $row = mysql_fetch_assoc($check);
                $userId = $row['user_id'];
                return $userId;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
//          echo 'exception'. $ex->getTrace();
//            exit;
        }

        return $userId;
    }

    public static function updateUser($userId, $authenticationMethodId, $firstName, $lastName, $email, $password = null,$phone=null) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set authentication_method_id = '" . $authenticationMethodId . "'
                          , first_name = '" . $firstName . "' ,last_name = '" . $lastName . "'
                          ,email = '" . $email . "' ,password = '" . $password . "' ,phone = '" . $phone . "' ,date_updated = '" . $mysqldate . "'
                          where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
    public static function updateEmail($userId) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set email = new_email,new_email= null ,date_updated = '" . $mysqldate . "'
                          where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
    public static function addNewEmail($userId, $newEmail) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set new_email ='". $newEmail ."',date_updated = '" . $mysqldate . "'
                          where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
     public static function updateName($userId, $firstName, $lastName) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set first_name = '" . $firstName . "' ,last_name = '" . $lastName . "'
                          ,date_updated = '" . $mysqldate . "'
                          where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
    public static function updatePhone($userId, $phone) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set phone = '" . $phone . "',date_updated = '" . $mysqldate . "'
                          where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
    public static function activateUser($userId) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update user_info set active_flag = 1,date_updated = '" . $mysqldate . "' where user_id = " . $userId;

            $update_user = mysql_query($update);
            if ($update_user) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
   
    public static function changePassword($userId, $oldPassword, $newPassword) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);

            $check = mysql_query("SELECT user_id FROM user_info WHERE user_id = '" . $userId . "' and password='" . $oldPassword . "'")
                    or die(mysql_error());

            $check2 = mysql_num_rows($check);
            
            if ($check2 > 0) {
                $update = "update user_info set password = '" . $newPassword . "',date_updated = '" . $mysqldate . 
                        "' where password='" . $oldPassword . "' and user_id = " . $userId;

                $update_user = mysql_query($update);
                if ($update_user) {
                    return true;
                }
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }
    
     public static function resetPassword($userId,$newPassword) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);

            $check = mysql_query("SELECT user_id FROM user_info WHERE user_id = '" . $userId . "'")
                    or die(mysql_error());

            $check2 = mysql_num_rows($check);
            
            if ($check2 > 0) {
                $update = "update user_info set password = '" . $newPassword . "',date_updated = '" . $mysqldate . 
                        "' where  user_id = " . $userId;

                $update_user = mysql_query($update);
                if ($update_user) {
                    return true;
                }
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }

    public static function updateAddressForUser($userId, $address = null, $city = null, $state = null, $country = null, $zip = null, $intersection = null, $lat = null, $lon = null) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;

        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME);


            $update = "update address set address = '" . $address . "' ,city = '" . $city . "'
                      ,state = '" . $state . "' ,country = '" . $country . "' ,zip = '" . $zip . "'
                      ,intersection = '" . $intersection . "' ,lat = '" . $lat . "' ,lon = '" . $lon . "'    
                       where user_id = " . $userId;

            $update_address = mysql_query($update);
            if ($update_address) {
                return true;
            }

            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }

        return false;
    }

    public static function addAddressForUser($userId, $address = null,$city = null, $state = null, $country = null, $zip = null, $intersection = null, $lat = null, $lon = null) {

        $mysqldate = date('Y-m-d H:i:s');
        $connection = null;
        try {
            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME) or die(mysql_error());

            $insert = "INSERT INTO address (user_id, address,city,state,country,zip,intersection,lat,lon,date_created)

 			VALUES ('" . $userId . "', '"  . $address . "','" . $city . "','" . $state . "','" . $country . "','" . $zip . "','" . $intersection . "','" . $lat . "','" . $lon . "','" . $mysqldate . "')";

            $add_address = mysql_query($insert);
            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }
    }

    public static function checkToken($token) {
        $userId = 0;
        $expiryDatetime = null;
        $currentDateTime = date('Y-m-d H:i:s');
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME) or die(mysql_error());
        $result = mysql_query("SELECT user_id,expiry_datetime FROM user_token WHERE token = '$token'")
                or die(mysql_error());
        $check2 = mysql_num_rows($result);

        if ($check2 > 0) {
            $row = mysql_fetch_assoc($result);
            $expiryDatetime = $row["expiry_datetime"];
            if ($expiryDatetime > $currentDateTime) {
                $userId = $row["user_id"];
                $expiryDateTime = date('Y-m-d H:i:s', strtotime(EXPIRY_AFTER));
                $update = mysql_query("UPDATE user_token set expiry_datetime= '$expiryDatetime' WHERE token = '$token'")
                        or die(mysql_error());
                User::setTokenInCookie($token);
            } else {
                //delete expired token from the database
                mysql_query("DELETE FROM user_token WHERE token = '$token'")
                        or die(mysql_error());
                User::clearTokenFromCookie("");
            }
            mysql_close($connection);
        }
        return $userId;
    }

    public static function setTokenInDB($userId, $token) {
        //delete existing token in DB
        $deleteToken = User::deleteTokenFromDBForUser($userId);
        //    
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME) or die(mysql_error());
        $currentDateTime = date('Y-m-d H:i:s');
        $expiryDateTime = date('Y-m-d H:i:s', strtotime(EXPIRY_AFTER));

        $insert = "INSERT INTO user_token (user_id,token,expiry_datetime) VALUES ('" . $userId . "','" . $token . "','" . $expiryDateTime . "')";
        $add_token = mysql_query($insert);

        mysql_close($connection);
        return $add_token;
    }

    public static function deleteTokenFromDB($token) {
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME) or die(mysql_error());
        $expiryDateTime = date('Y-m-d H:i:s', strtotime(EXPIRY_AFTER));
        $delete = "DELETE FROM  user_token WHERE token = '$token'";
        $deleteToken = mysql_query($delete);
        mysql_close($connection);
        return $deleteToken;
    }

    public static function deleteTokenFromDBForUser($userId) {
        $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
        mysql_select_db(DATABASE_NAME) or die(mysql_error());
        $delete = "DELETE FROM  user_token WHERE user_id = '$userId'";
        $deleteToken = mysql_query($delete);
        mysql_close($connection);
        return $deleteToken;
    }

    public static function createToken() {
        // Generate a randomized token
        $token = md5(microtime(TRUE) . rand(0, 100000));
        return $token;
    }

    public static function setTokenInCookie($token) {
        setcookie(COOKIE_NAME, $token, time() + 60 * 60 * 24 * 30, null, null);
    }

    public static function setAuthTypeInCookie($authenticationType) {
        setcookie(AUTH_TYPE_COOKIE_NAME, $authenticationType, time() + 60 * 60 * 24 * 30, null, null);
    }

    public static function clearTokenFromCookie($token) {
        setcookie(COOKIE_NAME, $token, time() - 3600, null, null);
    }

    public static function clearAuthTypeFromCookie($authenticationType) {
        setcookie(AUTH_TYPE_COOKIE_NAME, $authenticationType, time() - 3600, null, null);
    }

    public static function checkCookie() {
        if (isset($_COOKIE[COOKIE_NAME])) {
            return $_COOKIE[COOKIE_NAME];
        }
        return null;
    }

    public static function checkAuthCookie() {
        if (isset($_COOKIE[AUTH_TYPE_COOKIE_NAME])) {
            return $_COOKIE[AUTH_TYPE_COOKIE_NAME];
        }
        return null;
    }

    public static function createSuccessResponse($userId) {
        $userInfoRow = null;
        $addressInfoRow = null;
        $infoArray = null;
        $connection = null;
        try {


            $connection = mysql_connect(DATABASE_SERVER, DATABASE_USER_NAME, DATABASE_USER_PWD) or die(mysql_error());
            mysql_select_db(DATABASE_NAME) or die(mysql_error());
            $userInfo = mysql_query("SELECT authentication_method_id, first_name,last_name,email,active_flag,phone FROM user_info WHERE user_id = '$userId'")
                    or die(mysql_error());

            if (mysql_num_rows($userInfo) > 0) {
                $userInfoRow = mysql_fetch_assoc($userInfo);
            }

            $addressInfo = mysql_query("SELECT address,city,state, country,zip,intersection,lat,lon FROM address WHERE user_id = '$userId'")
                    or die(mysql_error());

            if (mysql_num_rows($addressInfo) > 0) {
                $addressInfoRow = mysql_fetch_assoc($addressInfo);
            }
            if ($userInfoRow != null) {
                $infoArray = array(
                    'status' => "success",
                    'user_id' => (int) $userId,
                    'authentication_method_id' => $userInfoRow['authentication_method_id'],
                    'first_name' => $userInfoRow['first_name'],                    
                    'last_name' => $userInfoRow['last_name'],
                    'email' => $userInfoRow['email'],
                    'phone' => $userInfoRow['phone'],
                    'active_flag' => $userInfoRow['active_flag'],
                    'address' => $addressInfoRow == null ? null : $addressInfoRow['address'],
                    
                    'city' => $addressInfoRow == null ? null : $addressInfoRow['city'],
                    'state' => $addressInfoRow == null ? null : $addressInfoRow['state'],
                    'country' => $addressInfoRow == null ? null : $addressInfoRow['country'],
                    'zip' => $addressInfoRow == null ? null : $addressInfoRow['zip'],
                    'intersection' => $addressInfoRow == null ? null : $addressInfoRow['intersection'],
                    'lat' => $addressInfoRow == null ? null : $addressInfoRow['lat'],
                    'lon' => $addressInfoRow == null ? null : $addressInfoRow['lon'],
                );
            }
            mysql_close($connection);
        } catch (Exception $ex) {
            mysql_close($connection);
        }
        if ($infoArray != null)
            return json_encode($infoArray);
        else
            return null;
    }

    public static function createFailureResponse($errorMessage) {
        $infoArray = array(
            'status' => 'failure',
            'errorMessage' => $errorMessage
        );
        return json_encode($infoArray);
    }

}

?>
