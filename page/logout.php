<?php
if (isset($_GET['page']) == 'logout') {
    $api->user->Logout();
}
?>