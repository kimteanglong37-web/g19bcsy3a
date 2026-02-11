<?php

function usernameExists($username)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_user WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    } else {
        return false;
    }
}
function registerUser($name, $username, $passwd)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_user (name,username,passwd) VALUES(?,?,?)');
    $query->bind_param('sss', $name, $username, $passwd);
    return $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function logUserIn($username, $passwd)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_user WHERE username = ? AND passwd = ?');
    $query->bind_param('ss', $username, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    } else {
        return false;
    }
}

function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_user WHERE id = ?');
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    } else {
        return null;

    }
}
function isAdmin()
{
    $user = loggedInUser();
    if ($user && $user->level === 'admin') {
        return true;
    }
    return false;
}
function isUserHasPassword($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('SELECT * FROM tbl_user WHERE id = ? AND passwd = ?');
    $query->bind_param('ds', $user->id, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}
function setUserNewPassword($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('UPDATE tbl_user SET passwd = ? WHERE id = ?');
    $query->bind_param('ds', $passwd, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;

}
