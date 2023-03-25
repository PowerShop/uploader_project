<?php
if (empty($_SESSION['user'])) {
    rdr('?page=login', 0);
} else {
    // do nothing...
}
$user = $_SESSION['user'];

if (isset($_POST['search-tag'])) {

    $tag = $_POST['tag'];
    $tag_s = $_POST['tag'];
    // // remove # from tag
    // $tag = str_replace("#", "", $tag);
    // $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%'";
    // Check if tag is # or @ and split sql query

    if (substr($_POST['tag'], 0, 1) == '#') {
        $tag = substr($_POST['tag'], 1);
        $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' AND `img_uploader` = '$user'  ORDER BY `img_id` DESC";
    } elseif (substr($_POST['tag'], 0, 1) == '@') {
        $tag = substr($_POST['tag'], 1);
        $i = "SELECT * FROM `uploader_image` WHERE `img_uploader` LIKE '%$tag%' AND `img_uploader` = '$user'  ORDER BY `img_id` DESC";
    } else {
        $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' AND `img_uploader` = '$user'  ORDER BY `img_id` DESC";
    }
} elseif (isset($_GET['tag'])) {
    // Show image from tag with url
    $tag = $_GET['tag'];
    $i = "SELECT * FROM `uploader_image` WHERE `img_tag` LIKE '%$tag%' AND `img_uploader` = '$user' ORDER BY `img_id` DESC";

} else {
    // Get all images from database
    $i = "SELECT * FROM `uploader_image` WHERE `img_uploader` = '$user' ORDER BY `img_id` DESC";
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Manage Image</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container pt-5">
        <div class="row mt-2 mb-5">
            <h1 class="text-light text-center mt-3 text-uppercase"><i class="fas fa-door-open    "></i> Manage Image Portal</h1>
            <?php
            
            if ($j = query($i)) {
                while ($k = $j->fetch()) {

            ?>
                    <div class="col-sm-4 mb-4">
                        <div class="card h-100 w-100">
                            <div class="card-head">
                                <!-- <img class="img-fluid w-100 h-100" src="./uploader_images/<?php echo $k['img_path']; ?>.<?php echo $k['img_type']; ?>" alt="Card image cap"> -->
                                <img class="img-fluid w-100 h-100" loading="lazy" data-bs-toggle="tooltip" data-bs-placement="top" title="กดเพื่อดูรูปภาพขนาดเต็ม" src="./uploader_images/<?php echo $k['img_path']; ?>.<?php echo $k['img_type']; ?>" alt="Card image cap" onclick="showFullSizeImage('<?php echo $k['img_path']; ?>', '<?php echo $k['img_type']; ?>')">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $k['img_name']; ?></h4>
                                <p class="card-text">by <?php echo $k['img_uploader']; ?>
                                </p>
                                <small>
                                    อัพโหลดเมื่อ
                                    <?php
                                    echo $k['img_create_time'];
                                    ?>
                                </small>
                                <div class="text-start">
                                    <small>
                                        Tags :
                                        <?php
                                        // split tags by comma
                                        $tags = explode(",", $k['img_tag']);
                                        // show each tag
                                        foreach ($tags as $tag) {
                                        ?>
                                            <a href="?page=home&tag=<?php echo $tag; ?>" class="badge text-bg-secondary mt-1" style="text-decoration: none;"><?php echo strtoupper($tag); ?></a>
                                        <?php
                                        }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">

                                <div class="text-start">

                                </div>
                                <div class="text-" style="max-width: 100%;">
                                    <button class="btn btn-outline-warning btn-sm edit-btn" data-toggle="tooltip" data-placement="top" title="แก้ไขรูปภาพนี้" data-imgid="<?php echo $k['img_id']; ?>" data-imgname="<?php echo $k['img_name']; ?>" data-imgtag="<?php echo $k['img_tag']; ?>" data-imgsrc="<?php echo $k['img_path'] . "." . $k['img_type']; ?>"><i class="fas fa-edit    "></i> แก้ไข</button>&nbsp;
                                    <button class="btn btn-danger delete-btn btn-sm" data-toggle="tooltip" data-placement="top" title="ลบรูปภาพนี้ ไม่สามารถกู้คืนได้" onclick="return deleteImage('<?php echo $k['img_id']; ?>')"><i class="fas fa-trash-alt    "></i> ลบรูปภาพนี้</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            // Check if there is no image found
            $count = $j->rowCount();
            if ($count < 1) { ?>
                <div class="text-center">
                    <h2 class="text-warning">ไม่พบรูปภาพที่ค้นหาด้วย <b>"<?php echo strtoupper($tag); ?>"</b></h2><br>
                    <a href="?page=manage-image" class="btn btn-warning"><i class="fas fa-arrow-left    "></i> ย้อนกลับ</a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script>
        // Show alert when click button #search-tag
        // Replace bdisable to button #search-tag
        $(document).ready(function() {
            // $("#search-tag").attr("disabled", true);
            $("#tag").attr("placeholder", "ค้นหารูปภาพของคุณ");


        });

        function showFullSizeImage(imgPath, imgType) {
            Swal.fire({
                imageUrl: './uploader_images/' + imgPath + '.' + imgType,
                imageAlt: 'Full-size Image',
                imageWidth: '90%',
                imageHeight: 'auto',
                imageBorderRadius: '10px',
                confirmButtonText: 'Close',
                confirmButtonColor: '#dc3545'
            });
        }

        // Get all download buttons with class name "download-btn"
        const editBtn = document.querySelectorAll('.edit-btn');

        // Loop through each download button and add a click event listener
        editBtn.forEach((btn) => {
            // Get image path from data-img attribute
            const imgId = btn.dataset.imgid;
            const imgName = btn.dataset.imgname;
            const imgTag = btn.dataset.imgtag;
            const imgSrc = btn.dataset.imgsrc;


            // Add a click event listener to the button
            btn.addEventListener('click', () => {

                Swal.fire({
                    title: '<strong><i class="fas fa-edit"></i> แก้ไขข้อมูลรูปภาพ</strong>',
                    imageUrl: './uploader_images/' + imgSrc,
                    imageAlt: 'Full-size Image',
                    imageWidth: '80%',
                    imageHeight: 'auto',
                    imageBorderRadius: '5px',
                    html: '<form action="" method="POST" class="text-start" id="editImage">' +
                        '<div class="mb-3">' +
                        '<label for="img_name" class="form-label"><i class="fas fa-image"></i> รูปภาพ</label>' +
                        '<input type="hidden" class="form-control" id="img_id" name="img_id"  value="' + imgId + '">' +
                        '<input type="text" class="form-control" id="img_name" name="img_name" placeholder="ชื่อรูปภาพ" value="' + imgName + '" required>' +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<label for="img_tag" class="form-label"><i class="fas fa-tags"></i> แท็กรูปภาพ</label>' +
                        '<input type="text" class="form-control" id="img_tag" name="img_tag" placeholder="Phone" value="' + imgTag + '" required>' +
                        '</div>' +
                        '<div class="text-center"><button type="submit" class="btn btn-primary" name="editImageSubmit"><i class="fas fa-save"></i> บันทึก</button></div>' +
                        '</form>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                });

            });
        });

        function deleteImage($id) {
            Swal.fire({
                title: 'คุณต้องการลบรูปภาพนี้ใช่หรือไม่?',
                text: "รูปภาพนี้จะถูกลบออกจากระบบ และไม่สามารถกู้คืนได้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบรูปภาพนี้',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "https://kittisakwebsite.epizy.com/page/delete_image.php",
                        type: "POST",
                        data: {
                            'id': $id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'ลบรูปภาพสำเร็จ!',
                                text: "รูปภาพนี้ถูกลบออกจากระบบแล้ว",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'ปิด'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            })
        }
    </script>
    <!-- Bootstrap JavaScript Libraries -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js" integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
// Check form submit editImageSubmit
if (isset($_POST['editImageSubmit'])) {
    // Get data to variable
    $img_id = $_POST['img_id'];
    $img_name = $_POST['img_name'];
    $img_tag = $_POST['img_tag'];

    // Update data to database
    query("UPDATE uploader_image SET img_name = '$img_name', img_tag = '$img_tag' WHERE img_id = '$img_id'");
    $api->alert->alertMessage("success", "บันทึกข้อมูลสำเร็จ", "เรากำลังพากลับไป...", "?page=manage-image", "2000", "true");
}
?>