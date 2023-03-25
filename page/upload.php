<?php
if (empty($_SESSION['user'])) {
    rdr('?page=login', 0);
} else {
    // do nothing...
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Uploader Portal</title>
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
    <div class="container-fluid py-1 mt-2 mb-5 pt-5">
        <h1 class="text-center text-light pt-2"><span><i class="fas fa-image    "></i> Upload Image</span> </h1>
        <div class="row d-flex justify-content-center align-items-center mb-5">
            <div class="col-12 col-md-8 col-lg-6 col-xl-8">
                <div class="bg-dark text-white p-3" style="border-radius: 1rem;">
                    <form id="image-upload-form" name="image-upload-form" enctype="multipart/form-data" method="post" action="">
                        <div class="mb-3">
                            <div class="preview-image text-center mx-auto" id="preview-image"></div>
                            <label for="image-upload" class="form-label"><i class="fas fa-upload"></i> เลือกรูปภาพ</label>
                            <input type="file" class="form-control" id="image-upload" name="image-upload" placeholder="รูปภาพที่ต้องการอัพโหลด" required>
                        </div>
                        <div class="mb-3">
                            <label for="image-title" class="form-label"><i class="fas fa-images"></i> ชื่อรูปภาพ</label>
                            <input type="text" class="form-control" id="image-title" name="image-title" placeholder="ตั้งชื่อรูปภาพของคุณ" required>
                        </div>
                        <div class="mb-3">
                            <label for="image-tags" class="form-label"><i class="fas fa-tags"></i> Tags</label>
                            <input type="text" class="form-control mb-1" id="image-tags" name="image-tags" placeholder="ใส่แท็กรูปภาพ" required>

                            <small class="text-start">ใส่ , คั่นแต่ละแท็ก</small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-upload    "></i> อัพโหลด</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php


    // Recive data from form
    if (isset($_POST['submit'])) {
        $file = $_FILES['image-upload'];
        $title = $_POST['image-title'];
        $tags = $_POST['image-tags'];

        

        // Upload file
        $uploadDir = 'uploader_images/';
        // $fileName = basename($file['name']);
        // $uploadFile = $uploadDir . $fileName;

        // Generate random name
        

        // Check file type
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        //  Check file size        
        $fileSize = $file['size'];

        // Check file type before upload
        if (!in_array($fileType, $allowTypes)) {
            $api->alert->alertMessage('error', 'อัพโหลดรูปภาพล้มเหลว', 'ไม่รองรับไฟล์ประเภท ' . $fileType . '', '?page=upload', '100', 'false');
        } else {
            // Insert data to database
            $user = $_SESSION['user'];
            $dateThai = DateThai();

            $file['name'] = randomName(8);
            $newFileName = $file['name'];

            $sql = query("INSERT INTO `uploader_image` (`img_uploader`, `img_name`, `img_path`, `img_size`, `img_type`, `img_tag`, `img_create_time`) VALUES ('$user', '$title', '$newFileName', '$fileSize', '$fileType', '$tags', '$dateThai')");
            $sql = query("UPDATE `user` SET `user_exp` = `user_exp` + 30 WHERE `user_name` = '$user'");
            
            // Upload file
            move_uploaded_file($file['tmp_name'], $uploadDir . $newFileName . '.' . $fileType);
            $api->alert->alertMessage('success', 'อัพโหลดรูปภาพเสร็จสิ้น', 'เราอัพโหลดรูปภาพของคุณแล้ว และคุณได้รับ 30 EXP!', '?page=upload', '100', 'false');
            // Add 30 EXP to user

        }
    }
    ?>

    <!-- Bootstrap JavaScript Libraries  -->
    <script>
        // Preview image
        $('#image-upload').change(function() {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').html('<img src="' + e.target.result + '" class="img-fluid mb-2 mx-auto w-50">');
            }
            reader.readAsDataURL(file);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>

</html>