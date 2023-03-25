<?php
if (empty($_SESSION['user'])) {
    $downloadable = false;
} else {
    $downloadable = true;
    $user = $_SESSION['user'];
}
// $filename = "image.jpg";
$file = $_GET['image'];
$img_path = $filenameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);


$i = query("SELECT * FROM `uploader_image` WHERE `img_path` = '$img_path'")->fetch();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Preview <?= $i['img_name']; ?></title>
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
    <!-- หน้าสำหรับดูรูปที่ถูกแชร์ -->
    <div class="container-fluid pt-5 mb-5">

        <div class="row">
            <div class="col-sm-4 pt-5 mb-5  mx-auto">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <img src="uploader_images/<?= $_GET['image']; ?>" alt="" class="img-fluid mb-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="กดเพื่อดูรูปภาพขนาดเต็ม" src="./uploader_images/<?php echo $k['img_path']; ?>.<?php echo $k['img_type']; ?>" alt="Card image cap" onclick="showFullSizeImage('<?php echo $i['img_path']; ?>', '<?php echo $i['img_type']; ?>')">
                        <h3 class="card-title"><?= $i['img_name']; ?></h3>
                        <p class="card-text">by <?= $i['img_uploader']; ?></p>
                        <small>
                                    อัพโหลดเมื่อ
                                    <?php
                                    echo $i['img_create_time'];
                                    ?>
                                </small><br>
                                <small>
                                    ขนาดไฟล์
                                    <?php
                                    // Convert Byte to Mb and Display like 3MB or 1.5MB
                                    $size = $i['img_size'];
                                    $size = $size / 1000000;
                                    echo number_format($size, 2) . "MB";
                                    
                                    
                                    ?>
                                </small>
                                <div class="text-start">
                                    <small>
                                        Tags :
                                        <?php
                                        // split tags by comma
                                        $tags = explode(",", $i['img_tag']);
                                        // show each tag
                                        foreach ($tags as $tag) {
                                        ?>
                                            <a href="?page=home&tag=<?php echo $tag; ?>" class="badge text-bg-secondary mt-1" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="แท็ก <?php echo strtoupper($tag); ?>"><?php echo strtoupper($tag); ?></a>
                                        <?php
                                        }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php if ($downloadable) { ?>
                                    <div class="text-start">
                                        <?php
                                        // Check if user is liked
                                        if ($api->user->checkUserIsLiked($user, $i['img_id'])) {
                                        ?>
                                            <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Liked!"><i class="fas fa-thumbs-up    "></i>
                                                <?php
                                                // Get number of likes
                                                $likes = $api->user->getNumberOfLikes($i['img_id']);
                                                echo $likes; ?> Like</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn btn-outline-primary" id="like-button" data-toggle="tooltip" data-placement="top" title="Like!" data-imageid="<?php echo $i['img_id']; ?>" data-user="<?php echo $_SESSION['user']; ?>" data-like="<?php echo $api->user->getNumberOfLikes($i['img_id']); ?>" data-imgn="<?php echo $i['img_name']; ?>"><i class="fas fa-thumbs-up    "></i> <?php $likes = $api->user->getNumberOfLikes($i['img_id']);
                                                                                                                                                                                                                                                                                                                                                                                                            echo $likes; ?> Like</button>
                                        <?php } ?>
                                    </div>
                                    <div class="text-end" style="max-width: 100%;">
                                        <button class="btn btn-outline-warning btn-sm share-btn" data-toggle="tooltip" data-placement="top" title="แชร์รูปภาพนี้กับเพื่อน ๆ ของคุณ" data-img="<?php echo $i['img_path'] . "." . $i['img_type']; ?>" data-imgname="<?php echo $i['img_name']; ?>"><i class="fas fa-share-alt    "></i> Share</button>&nbsp;
                                        <button class="btn btn-success download-btn btn-sm" data-toggle="tooltip" data-placement="top" title="ดาวน์โหลดรูปภาพนี้" data-img="<?php echo $i['img_path'] . "." . $i['img_type']; ?>" data-imgname="<?php echo $i['img_name']; ?>" data-imgauthor="<?php echo $i['img_uploader']; ?>"><i class="fas fa-download    "></i> Download</button>
                                    </div>
                                <?php } else { ?>
                                    <div class="text-center mw-100 mx-auto">
                                        <small class="text-danger">* โปรดเข้าสู่ระบบก่อนดาวน์โหลดหรือแชร์รูปภาพ</small>
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        // Get all download buttons with class name "download-btn"
        const downloadBtns = document.querySelectorAll('.download-btn');

        // Loop through each download button and add a click event listener
        downloadBtns.forEach((btn) => {
            // Get image path from data-img attribute
            const imgPath = btn.dataset.img;
            const imageName = btn.dataset.imgname;
            const imageAuthor = btn.dataset.imgauthor;

            // Add a click event listener to the button
            btn.addEventListener('click', () => {
                // Show a SweetAlert2 confirmation dialog
                Swal.fire({
                    title: 'ยืนยันการดาวน์โหลด?',
                    text: 'คุณต้องการที่จะดาวน์โหลดรูปภาพ ' + imageName + ' ใช่หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ดาวน์โหลด',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    // If the user confirmed the download, initiate the download
                    if (result.isConfirmed) {
                        // Create a new anchor element with the image source as the href
                        const link = document.createElement('a');
                        link.href = 'uploader_images/' + imgPath;
                        link.download = imgPath;

                        // Click the anchor element to start the download
                        link.click();

                        // Show alert when downlaod is complete
                        Swal.fire({
                            title: 'ดาวน์โหลดเสร็จสิ้น!',
                            text: 'รูปภาพ ' + imageName + ' ถูกดาวน์โหลดเรียบร้อยแล้ว อย่าลืมแชร์รูปภาพนี้กับเพื่อน ๆ ของคุณ หรือไปเยี่ยมชมผลงานของผู้อัปโหลดได้ที่โปรไฟล์ของ ' + imageAuthor,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ตกลง',
                        });

                    }
                });
            });
        });

        // Share Image
        // Get all share buttons with class name "share-btn"
        const shareBtns = document.querySelectorAll('.share-btn');
        // Loop through each download button and add a click event listener
        shareBtns.forEach((btn) => {
            // Get image path from data-img attribute
            const imagePath = btn.dataset.img;
            const imageName = btn.dataset.imgname;
            const imageAuthor = btn.dataset.imgauthor;

            // Add a click event listener to the button
            btn.addEventListener('click', () => {
                // แสดงหน้าต่างแชร์รูปภาพโดยมีช่องลิ้งค์ และสามารถกด Copy ได้
                Swal.fire({
                    title: 'แชร์รูปภาพ ' + imageName + ' กับเพื่อน ๆ ของคุณ',
                    icon: 'info',
                    html: 'คุณสามารถแชร์รูปภาพนี้ได้โดยการกด Ctrl + C หรือคลิกที่ช่องข้อความแล้วกด Ctrl + V ไปที่ที่ต้องการแชร์ <br> <textarea name="" class="form-control" readonly id="" cols="50" rows="3">https://kittisakwebsite.epizy.com/?page=preview-image&image=' + imagePath + '</textarea>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง',
                });
                
            });
        });

        function showFullSizeImage(imgPath, imgType) {
            Swal.fire({
                imageUrl: './uploader_images/' + imgPath + '.' + imgType,
                imageAlt: 'Full-size Image',
                imageWidth: '90%',
                imageHeight: 'auto',
                confirmButtonText: 'Close',
                confirmButtonColor: '#dc3545'
            });
        }

        // Like System
        // AJAX request to like.php
        const likeBtn = document.querySelectorAll('#like-button');

        likeBtn.forEach((btn) => {
            btn.addEventListener('click', (event) => {
                // Get the image ID and user ID from the data attributes
                const imageId = event.target.dataset.imageid;
                const user = event.target.dataset.user;
                const likeCount = event.target.dataset.like;
                const imgName = event.target.dataset.imgn;

                // Send AJAX request to server
                $.ajax({
                    url: 'https://kittisakwebsite.epizy.com/page/like.php',
                    type: 'post',
                    data: {
                        'image_id': imageId,
                        'user': user
                    },
                    success: function(response) {
                        // Handle success response from server
                        if (response === 'success') {
                            // Change the like button from outline to filled
                            event.target.classList.remove('btn-outline-primary');
                            event.target.classList.add('btn-primary');

                            // Replace the like button text with the new like count
                            event.target.innerHTML = '<i class="fas fa-thumbs-up"></i> ' + (parseInt(likeCount) + 1) + ' Like';

                            // SweetAlert2 toasts for success
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'info',
                                title: 'คุณกดไลก์รูป ' + imgName + ' และได้รับ 10 EXP!'
                            })


                        }
                    }
                });
            });
        });
    </script>
    <!-- Bootstrap JavaScript Libraries -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js" integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>