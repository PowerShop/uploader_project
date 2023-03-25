<?php
if (empty($_SESSION['user']) or $_SESSION['admin'] != "true") {
    $api->alert->alertMessage("error", "ไม่สามารถเข้าถึงได้", "คุณไม่มีสิทธิ์เข้าถึงหน้านี้", "?page=home", "3000", "false");
    rdr("?page=home", 3100);
} else {
    // do nothing...
    $user = $_SESSION['user'];
}



?>
<!doctype html>
<html lang="en">

<head>
    <title>Backend</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/02e207a49a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <?php
    if ($_SESSION['admin'] != "true") {
    } else {
    ?>

        <div class="container-fluid pt-5 mb-5">
            <h1 class="text-center text-uppercase text-light mt-4"><i class="fas fa-door-open    "></i> backend portal</h1>
            <?php
            // appear button ig $_GET['manage-image']
            if (isset($_GET['manage-image'])) {
                echo '<a type="button" class="btn btn-success btn-sm" href="?page=backend"><i class="fas fa-arrow-left   "></i> ย้อนกลับไปหน้า Backend</a>';
            }
            ?>


            <div class="row mt-2 mb-5">
                <!-- Membership -->
                <?php
                if (isset($_GET['manage-image'])) {

                ?>
                    <?php
                    $user = $_SESSION['user'];
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
                            <a href="?page=backend&manage-image" class="btn btn-warning"><i class="fas fa-arrow-left    "></i> ย้อนกลับ</a>
                        </div>
                    <?php
                    }
                    ?>
                <?php
                } else {
                    $membership = query("SELECT * FROM `membership`")->fetch();
                ?>
                    <div class="col-sm-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">Membership Setting</h4>
                                <p class="card-text">
                                    <?php
                                    // ลูปข้อมูลจากตาราง membership
                                    $sql = "SELECT * FROM `membership`";

                                    if ($q = query($sql)) {
                                        while ($row = $q->fetch()) {
                                    ?>
                                <div class="card mb-3 border border-0">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <img src="badge/<?php echo $row['membership_badge']; ?>" alt="" class="img-fluid rounded-start" width="64" height="64">
                                        </div>
                                        <div class="col-6">
                                            <div class="card-body">
                                                <h6 class="card-title"><b>Rank : <?php echo $row['membership_name']; ?></b></h6>
                                                <p class="card-text">EXP ที่ใช้ : <?php echo $row['membership_exp']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="text-decoration-none" id="editMembership" data-badge="<?php echo $row['membership_badge']; ?>" data-name="<?php echo $row['membership_name']; ?>" data-exp="<?php echo $row['membership_exp']; ?>" data-id="<?php echo $row['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="แก้ไขแรงค์ <?php echo $row['membership_name']; ?>"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </div>
                                </div>

                        <?php
                                        }
                                    }
                        ?>
                        </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">General</h4>
                                <p class="card-text">
                                <div class="mb-3">
                                    <label for="" class="form-label">จัดการรูปภาพที่อัพโหลดทั้งหมด</label>
                                    <a type="button" class="btn btn-primary" href="?page=backend&manage-image"><i class="fas fa-edit    "></i> MANAGE</a>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center"><i class="fa-solid fa-spinner fa-spin"></i> Comming soon...</h4>
                                <p class="card-text">

                                </p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    <?php
                }
    ?>
    <script>
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

        function showFullSizeImage(imgPath, imgType) {
            Swal.fire({
                imageUrl: './uploader_images/' + imgPath + '.' + imgType,
                imageWidth: '90%',
                imageHeight: 'auto',
                imageBorderRadius: '10px',
                confirmButtonText: 'Close',
                confirmButtonColor: '#dc3545'
            });
        }

        // Get all download buttons with class name "download-btn"
        const editBtn = document.querySelectorAll('#editMembership');

        // Loop through each download button and add a click event listener
        editBtn.forEach((btn) => {
            // Get image path from data-img attribute
            const badge = btn.dataset.badge;
            const name = btn.dataset.name;
            const exp = btn.dataset.exp;
            const id = btn.dataset.id;

            // Add a click event listener to the button
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: '<strong><i class="fas fa-edit"></i> แก้ไขแรงค์</strong>',
                    html: '<form action="" method="POST" class="text-start" id="editImage" enctype="multipart/form-data">' +
                        '<div id="imagePreview" class="text-center"></div>' +
                        '<div class="mb-3 text-center">' +
                        '<img src="badge/' + badge + '" class="img-fluid current-image mx-auto" alt="">' +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<label for="mem_badge" class="form-label"><i class="fas fa-image    "></i> รูปภาพ</label>' +
                        '<input type="file" class="form-control" id="mem_badge" name="mem_badge" placeholder="รูปภาพ" onchange="previewImage(event)">' +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<label for="mem_name" class="form-label"><i class="fas fa-trophy    "></i> ชื่อแรงค์</label>' +
                        '<input type="hidden" class="form-control" id="mem_id" name="mem_id"  value="' + id + '">' +
                        '<input type="text" class="form-control" id="mem_name" name="mem_name" placeholder="ตั้งชื่อแรงค์" value="' + name + '" required>' +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<label for="mem_exp" class="form-label"><i class="fas fa-flask    "></i> EXP ที่ต้องใช้</label>' +
                        '<input type="text" class="form-control" id="mem_exp" name="mem_exp" placeholder="Phone" value="' + exp + '" required>' +
                        '</div>' +
                        '<div class="text-center"><button type="submit" class="btn btn-primary" name="editMembershipSubmit"><i class="fas fa-save"></i> บันทึก</button></div>' +
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

        // Preview image
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.innerHTML = '<img src="' + reader.result + '" class="img-fluid">';
                // Hide imageUrl
                $("img.current-image").css("display", "none");

            }
            reader.readAsDataURL(event.target.files[0]);
        }

        
    </script>
    <?php
        if (isset($_POST['editMembershipSubmit'])) {
           
            $mem_id = $_POST['mem_id'];
            $mem_name = $_POST['mem_name'];
            $mem_exp = $_POST['mem_exp'];

            $mem_badge = $_FILES['mem_badge'];

            $fileType = pathinfo($mem_badge['name'], PATHINFO_EXTENSION);

            // Change the image name to match the JP name
            // $new_name = $anime_image['name'];

            // Move the uploaded file to the destination directory
            // Check if the file is empty use old data from database

            $save = query("SELECT * FROM membership WHERE id = $mem_id")->fetch();
            $old_image = query("SELECT * FROM membership WHERE id = $mem_id")->fetch();
            $old_image_name = $old_image['membership_badge'];

            if (isset($_FILES['mem_badge']) && $_FILES['mem_badge']['error'] != UPLOAD_ERR_NO_FILE) {
                // Delete old image
                unlink("badge/" . $old_image_name);
            
                // Set file name same as the $mem_name
                $mem_badge['name'] = $mem_name . "." . $fileType;
                $new_name = $mem_badge['name'];
                
                // Clear cache before upload
                clearstatcache();

                move_uploaded_file($mem_badge['tmp_name'], "badge/" . $mem_badge['name']);

            } elseif ($mem_name != $save['membership_name']) {
                // Get old file type
                $fileType = pathinfo($old_image_name, PATHINFO_EXTENSION);

                // Update image name
                $new_name = $mem_name. "." . $fileType;

                // Clear cache before rename
                clearstatcache();
                rename("badge/" . $old_image_name, "badge/" . $new_name);

            } else {
                $new_name = $old_image_name;
            }
            


            $sql = query("UPDATE membership SET `membership_name` = '$mem_name', `membership_exp` = '$mem_exp', membership_badge = '$new_name' WHERE id = $mem_id");
            $api->alert->alertMessage('success', 'แก้ไขแรงค์สำเร็จ!', 'แก้ไขแรงค์สำเร็จ!', '?page=backend', '1500', 'false');
        }
    ?>
<?php
    }
?>
<!-- Bootstrap JavaScript Libraries -->
<script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js" integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>

</body>

</html>