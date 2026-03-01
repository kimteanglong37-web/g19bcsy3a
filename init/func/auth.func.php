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
function changeProfileImage($image)
{
    global $db;
    $user = loggedInUser();
    $image_path = uploadImage($image);
    if ($image_path && $user->photo) {
        unlink($user->photo);
    }
    $query = $db->prepare('UPDATE tbl_user SET photo = ? WHERE id = ?');
    $query->bind_param('sd', $image_path, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function deleteProfileImage()
{
    global $db;
    $user = loggedInUser();
    if ($user->photo) {
        unlink($user->photo);
    }
    $query = $db->prepare('UPDATE tbl_user SET photo = NULL WHERE id = ?');
    $query->bind_param('d', $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}


function uploadImage($image)
{
    $img_name = $image['name'];
    $img_size = $image['size'];
    $tmp_name = $image['tmp_name'];
    $error = $image['error'];

    $dir = './assets/images/';

    $allow_exs = ['jpg', 'png', 'jpeg'];
    $image_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $image_lowercase_ex = strtolower($image_ex);

    if (!in_array($image_lowercase_ex, $allow_exs)) {
        throw new Exception('File extension is not allowed!');
    }

    if ($error > 0) {
        throw new Exception('Unknown error occurred!');
    }

    if ($img_size > 500000) {
        throw new Exception('File size is too large!');
    }

    $new_image_name = uniqid("Image-") . '.' . $image_lowercase_ex;
    $image_path = $dir . $new_image_name;
    move_uploaded_file($tmp_name, $image_path);
    return $image_path;
}
