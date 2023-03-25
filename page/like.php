<?php
include_once dirname(__FILE__) . '/../systems/sys.php';
if ($_POST['image_id']) {
    global $api;
    // $pdo = new PDO('mysql:host=sql206.epizy.com;dbname=epiz_33843964_mini_project', 'Kittisak110', 'epiz_33843964');
    // $pdo = new PDO('mysql:host=localhost;dbname=mini-project', '', 'root');
    // Retrieve the image ID from the AJAX request
    $imageId = $_POST['image_id'];
    $user = $_POST['user'];

    // Get author of image
    $get_author = $api->sql->prepare("SELECT * FROM `uploader_image` WHERE `img_id` = ?");
    $get_author->execute([$imageId]);
    $k = $get_author->fetch();
    $user_author = $k['img_uploader'];

    // Get user id
    $usr_id = $api->sql->prepare("SELECT * FROM `user` WHERE `user_name` = ?");
    $usr_id->execute([$user]);
    $j = $usr_id->fetch();
    $user_id = $j['user_id'];

    // Perform the necessary logic for updating the like count in your database
    // Get user id from session
    $stmt = $api->sql->prepare("SELECT * FROM `user` WHERE `user_name` = ?");
    $stmt->execute([$user]);
    $i = $stmt->fetch();
    $userId = $i['user_id'];

    $stmt = $api->sql->prepare("SELECT * FROM `like` WHERE `img_id` = ? AND `user_id` = ?");
    $stmt->execute([$imageId, $userId]);
    $count = $stmt->rowCount();

    if ($count < 1) {
        $stmt = $api->sql->prepare("INSERT INTO `like` (`img_id`, `user_id`) VALUES (?, ?)");
        $stmt->execute([$imageId, $userId]);

        // Add 10 EXP to user
        $stmt = $api->sql->prepare("UPDATE `user` SET `user_exp` = `user_exp` + 10 WHERE `user_id` = ?");
        $stmt->execute([$userId]);
        
        // Add 1 like to image
        $stmt = $api->sql->prepare("UPDATE `uploader_image` SET `img_like` = `img_like` + 1 WHERE `img_id` = ?");
        $stmt->execute([$imageId]);

        // Add 1 like to author of image
        $stmt = $api->sql->prepare("UPDATE `user` SET `user_like` = `user_like` + 1 WHERE `user_name` = ?");
        $stmt->execute([$user_author]);

        // Send a response back to the JavaScript code
        echo 'success';
    } else {
        // Handle case where user has already liked this image
    }

} else {
    rdr('?page=home', 0);
}
