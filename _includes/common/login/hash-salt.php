<?php
//some salt, this would be stored in your database
$salt = "abc123";
//hash of string "abc123squirrel", this would be also stored in your database
//password is ofcourse squirrel
$hashStored = "eb5c28c5a881fff827014ad530c8a580bd7ac42e";
$hashVerify = sha1($salt . $_GET['pass']);
//try to run this script with query parameter pass set to various values
if($hashStored == $hashVerify) {
    //hash-salt.php?pass=squirrel
    echo "hashes do match";
} else {
    //hash-salt.php?pass=hippopotamus
    echo "hashes do NOT match";
}
