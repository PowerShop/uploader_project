<head>
    <meta property="og:title" content="Uploader's" />
    <meta property="og:image" content="https://kittisakwebsite.epizy.com/dist/image/uploader_logo.png" />
    <meta property="og:description" content="อัปโหลดรูป ดาวน์โหลด และแชร์กับเพื่อน ๆ ของคุณ" />
    <meta property="og:url" content="https://kittisakwebsite.epizy.com" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="540" />
    <!-- <link rel="icon" type="image/x-icon" href="https://kittisakwebsite.epizy.com/dist/image/favicon.ico"> -->

    <link rel="apple-touch-icon" sizes="180x180" href="dist/image/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="dist/image/favicon/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="192x192" href="dist/image/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="dist/image/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="dist/image/favicon/favicon-16x16.png">
    <link rel="manifest" href="dist/image/favicon/site.webmanifest">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<?php
// display errors
ini_set('display_errors', 1);
include "systems/sys.php";

// ค้นหารูป
if (isset($_POST['search-tag'])) {

    $tag = $_POST['tag'];
    $tag_s = $_POST['tag'];
    // // remove # from tag
    // $tag = str_replace("#", "", $tag);
    // $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%'";
    // Check if tag is # or @ and split sql query

    if (substr($_POST['tag'], 0, 1) == '#') {
        $tag = substr($_POST['tag'], 1);
        $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' ORDER BY `img_id` DESC";
    } elseif (substr($_POST['tag'], 0, 1) == '@') {
        $tag = substr($_POST['tag'], 1);
        $i = "SELECT * FROM `uploader_image` WHERE `img_uploader` LIKE '%$tag%' ORDER BY `img_id` DESC";
    } else {
        $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' ORDER BY `img_id` DESC";
    }
} elseif (isset($_GET['tag'])) {
    // Show image from tag with url
    $tag = $_GET['tag'];
    $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' ORDER BY `img_id` DESC";
} else {
    // Get all images from database
    $i = "SELECT * FROM `uploader_image` ORDER BY `img_id` DESC";
}

// Include Navbar 
// Condition not load navbar if while in 404 page
if ($_GET['page'] != '404') {
    include "./page/navbar.php";
} else {
    # do nothing...
}

// Get Page
if ($_GET['i']) {
    rdr('?page=home', 10);
} elseif ($_GET) {
} else {
    rdr('?page=home', 10);
}

if (isset($_GET['page'])) {
    $page = './page/' . $_GET['page'] . '.php';
    if (file_exists($page)) {

        include $page;
    } else {
        rdr('?page=404', 10);
    }
}


// Include Footer
if ($_GET['page'] != '404') {
    include "./page/footer.php";
} else {
    # do nothing...
}
?>
<link rel="stylesheet" href="./dist/css/style.css">