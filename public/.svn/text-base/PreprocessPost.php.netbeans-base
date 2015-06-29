#!/usr/bin/php
<?php


//set POST variables
$url = 'http://sf.localjoe.com/post/preprocess';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);

//execute post
$result = curl_exec($ch);
echo $result;

//close connection
curl_close($ch);



?>