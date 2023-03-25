<?php
include_once dirname(__FILE__) . '/../systems/sys.php';
if (empty($_SESSION['user'])) {
    rdr('?page=login', 10);
} else {
    if ($_POST['id']) {
        $img_id = $_POST['id'];

        // Get image name and type
        $stmt = $api->sql->prepare("SELECT * FROM `uploader_image` WHERE `img_id` = ?");
        $stmt->execute([$img_id]);
        $img = $stmt->fetch(PDO::FETCH_ASSOC);
    
        

        // Delete image and return success response
        $stmt = $api->sql->prepare("DELETE FROM `uploader_image` WHERE `img_id` = ?");
        $stmt->execute([$img_id]);

        // delete image from folder uplaoder_images
        if(unlink("../uploader_images/" . $img['img_path'] . "." . $img['img_type'])) {
            echo "success";
        } else {
            echo "error";
        }

    }
}
    
