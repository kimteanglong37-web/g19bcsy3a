<?php
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
} else {
    echo "Hi";
}
?>
<h1> Dashboard</h1>