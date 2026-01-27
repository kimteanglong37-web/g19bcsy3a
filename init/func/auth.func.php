<?php

function usernameExists($username){
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_user WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows){
        return true;
    }else {
        return false;
    }
}
function registerUser($name, $username, $passwd)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_user (name,username,passwd) VALUES(?,?,?)');
    $query->bind_param('sss', $name,$username,$passwd);
    return $query->execute();
    if($db->affected_rows) {
        return true;
    }
    return false;
}