<?php
if (empty($_SESSION['user'])) {
    rdr('?page=login', 0);
} else {
    // do nothing...
    $user = $_SESSION['user'];
}
?>
<!doctype html>
<html lang="en">

<head>
    <title><?php echo $_SESSION['user']; ?>'s Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container pb-5 pt-5">
        <h1 class="text-light text-center mb-3 text-uppercase pt-3"><i class="fas fa-door-open    "></i> profile portal</h1>
        <?php
        $user = $_SESSION['user'];
        $profile = query("SELECT * FROM `user` WHERE `user_name` = '$user'")->Fetch();
        // Join table between user and membership
        $membership = query("SELECT * FROM `user` JOIN `membership` ON `user`.`user_membership` = `membership`.`membership_reference` WHERE `user_name` = '$user'")->Fetch();
        $membership_next = query("SELECT * FROM `membership` WHERE `membership_reference` = '$membership[membership_reference]' + 1")->Fetch();
        $api->user->checkMembership($user);
        ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="<?php echo $profile['user_avatar']; ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <br>
                        <div class="mt-1"><a style="font-size: 12px; color: rgba(0, 0, 0, 0.3);" class="text-center" onclick="return changeProfilePicture()"><i class="fas fa-pen    "></i> Edit</a></div>
                        <h5 class="my-2"><?php echo $profile['user_name']; ?></h5>
                        <p class="text-muted mb-1"><img src="badge/<?php echo $membership['membership_badge']; ?>" alt="" width="32px" height="32px"> <?php echo $membership['membership_name']; ?></p>
                        <br>
                        <!-- Spilt text to left and right in one line-->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-1 text-start" style="font-size: .77rem;">
                                <!-- Check Rank is Max -->
                                <?php if ($profile['user_membership'] == 4) { ?>
                                    <img src="badge/<?php echo $membership['membership_badge']; ?>" alt="" width="32px" height="32px"> <?php echo $membership['membership_name']; ?>
                                <?php } else { ?>
                                    Next Rank <img src="badge/<?php echo $membership_next['membership_badge']; ?>" alt="" width="32px" height="32px"> <?php echo $membership_next['membership_name']; ?>
                                <?php } ?>
                            </div>
                            <div class="mb-1 text-end" style="font-size: .77rem;">EXP <?php echo $profile['user_exp']; ?>/<?php echo $membership['membership_exp']; ?></div>

                        </div>

                        <!-- Progress bar -->
                        <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo ((100 * $profile['user_exp']) / $membership['membership_exp']); ?>%" aria-valuenow="<?php echo $profile['user_exp']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $membership['membership_exp']; ?>"></div>
                        </div>
                        <!-- <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-primary">Follow</button>
                                <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                            </div> -->
                    </div>
                </div>
                <!-- Show Liked -->
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fas fa-thumbs-up"></i>
                                <p class="mb-0"><?php echo $profile['user_like']; ?> LIKES</p>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- <div class="card mb-4 mb-lg-0 mt-4">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                    <p class="mb-0">@mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                            </ul>
                        </div>
                    </div> -->
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0"><i class="fas fa-user-alt    "></i> Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $profile['user_name']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0"><i class="fas fa-envelope    "></i> Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $profile['user_email']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0"><i class="fas fa-phone    "></i> Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $profile['user_phone']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0"><i class="fas fa-calendar-alt    "></i> Registered Date</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo $profile['create_time']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-sm-7">
                                        <p class="mb-1"><i class="fas fa-edit    "></i> Edit Profile</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <p class="mb-1"><button type="button" class="btn btn-success btn-sm" onclick="return editProfile()"><i class="fas fa-edit"></i> EDIT</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-sm-7">
                                        <p class="mb-1"><i class="fas fa-lock    "></i> Your Password</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <!-- <p class="mb-1"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#changePassword"><i class="fas fa-edit    "></i> CHANGE</button></p> -->
                                        <p class="mb-1"><button type="button" class="btn btn-warning btn-sm" onclick="return changePassword()"><i class="fas fa-edit    "></i> CHANGE</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Section User can edit them image -->
                    <div class="col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-sm-7">
                                        <p class="mb-1"><i class="fas fa-edit    "></i> Manage Image</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <p class="mb-1"><button type="button" class="btn btn-primary btn-sm" onclick="return goToManageImage()"><i class="fas fa-edit"></i> MANAGE</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Section Backend -->
                    <!-- <div class="col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-sm-7">
                                        <p class="mb-1"><i class="fas fa-cogs    "></i> Backend</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <p class="mb-1"><button type="button" class="btn btn-danger btn-sm" onclick="return goToBackend('<?php echo $user; ?>')"><i class="fas fa-edit"></i> Backend</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal EDIT Profile -->

    <script>
        // Function Change Password
        function changePassword() {
            Swal.fire({
                title: '<strong>Change your password</strong>',
                icon: 'info',
                html: '<form action="" method="POST" class="text-start" id="changePassword">' +
                    '<div class="mb-3">' +
                    '<label for="oldPassword" class="form-label"><i class="fas fa-lock    "></i> รหัสผ่านปัจจุบัน</label>' +
                    '<input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old Password" required>' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<label for="newPassword" class="form-label"><i class="fas fa-lock    "></i> รหัสผ่านใหม่</label>' +
                    '<input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<label for="confirmPassword" class="form-label"><i class="fas fa-lock    "></i> ยืนยันรหัสผ่าน</label>' +
                    '<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>' +
                    '</div>' +
                    '<div class="text-center"><button type="submit" class="btn btn-primary" name="changePasswordSubmit">เปลี่ยนรหัสผ่าน</button></div>' +
                    '</form>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,


            });
        }

        // Function Edit Profile

        function editProfile() {
            Swal.fire({
                title: '<strong>Edit your profile</strong>',
                icon: 'info',
                html: '<form action="" method="POST" class="text-start" id="editProfile">' +
                    '<div class="mb-3">' +
                    '<label for="email" class="form-label"><i class="fas fa-envelope    "></i> Email</label>' +
                    '<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $profile['user_email']; ?>" required>' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<label for="phone" class="form-label"><i class="fas fa-phone    "></i> Phone</label>' +
                    '<input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $profile['user_phone']; ?>" required>' +
                    '</div>' +
                    '<div class="text-center"><button type="submit" class="btn btn-primary" name="editProfileSubmit">แก้ไขข้อมูล</button></div>' +
                    '</form>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
            });
        }

        // Function Change Profile Picture
        function changeProfilePicture() {
            Swal.fire({
                title: '<strong>Change your profile picture</strong>',
                html: '<form action="" method="POST" class="text-start" id="changeProfilePicture" enctype="multipart/form-data">' +
                    '<div id="imagePreview" class="text-center"></div>' +
                    '<div class="mb-3">' +
                    '<label for="profilePicture" class="form-label"><i class="fas fa-image    "></i> รูปโปรไฟล์</label>' +
                    '<input type="file" class="form-control" id="profilePicture" name="profilePicture" placeholder="Profile Picture"  onchange="previewImage(event)" required>' +
                    '</div>' +
                    '<div class="text-center"><button type="submit" class="btn btn-primary" name="changeProfilePictureSubmit">เปลี่ยนรูปโปรไฟล์</button></div>' +
                    '</form>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
            });
        }

        // Function goToManageImage()
        function goToManageImage() {
            Swal.fire({
                title: '<strong>เรากำลังพาคุณไป</strong>',
                icon: 'info',
                text: 'กำลังเปลี่ยนหน้า...',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                timer: 1000,
                timerProgressBar: true,

            });
            setTimeout(function() {
                window.location.href = "?page=manage-image";
            }, 1000);
        }

        // Show alert when click button #search-tag
        // Replace bdisable to button #search-tag
        $(document).ready(function() {
            // $("#search-tag").attr("disabled", true);
            $("i.fa-search").removeClass("fa-search").addClass("fa-lock");
            $("#tag").removeAttr("required").attr("disabled", true);
            $("#search-tag").removeAttr("type");
            $("#search-tag").attr("type", "button");
            $("#tag").attr("placeholder", "X ไม่สามารถค้นหาในหน้านี้ได้");
            // Change btn color
            $("#search-tag").removeClass("btn-outline-primary").addClass("btn-danger");



        });

        $("#search-tag").click(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'warning',
                title: 'ไม่สามารถค้นหาในหน้านี้ได้'
            })
        });

        


        // Preview image
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.innerHTML = '<img src="' + reader.result + '" class="img-fluid">';

            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <?php
    // Check if search has value
    if (isset($_POST['search-tag'])) {
        echo "
        </script>";
    }

    // Change Password
    if (isset($_POST['changePasswordSubmit'])) {
        $user = $_SESSION['user'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        // Check Old Password and New Password is same
        if ($confirmPassword === $newPassword) {
            $api->user->changePassword($user, $oldPassword, $newPassword);
        } else {
            $api->alert->alertMessage("error", "ดำเนินการไม่สำเร็จ", "รหัสผ่านไม่ตรงกัน", "?page=profile", "2000", "false");
        }
    }

    // Edit Profile
    if (isset($_POST['editProfileSubmit'])) {
        $user = $_SESSION['user'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $api->user->changeProfile($user, $email, $phone);
    }

    // Change Profile Picture
    if (isset($_POST['changeProfilePictureSubmit'])) {
        clearstatcache();
        $user = $_SESSION['user'];
        $profilePicture = $_FILES['profilePicture'];

        // Get file type
        $fileType = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

        // Change file name to same as username
        $profilePicture['name'] = $user . "." . $fileType;
        $P = $profilePicture['name'];

        // Check file type
        if (!in_array($fileType, $allowTypes)) {
            $api->alert->alertMessage("error", "ดำเนินการไม่สำเร็จ", "รูปโปรไฟล์ต้องเป็นไฟล์รูปภาพหรือ Gif เท่านั้น", "?page=profile", "2000", "false");
            exit();
        } else {
            // Upload file and clear cache
            clearstatcache();
            move_uploaded_file($profilePicture['tmp_name'], "avatar/" . $profilePicture['name']);
            // SQL
            $cPic = query("UPDATE user SET user_avatar = 'avatar/$P' WHERE user_name = '$user'");
            // Check SQL
            if ($cPic) {
                $api->alert->alertMessage("success", "ดำเนินการสำเร็จ", "เปลี่ยนรูปโปรไฟล์สำเร็จ", "?page=profile", "2000", "false");
            } else {
                $api->alert->alertMessage("error", "ดำเนินการไม่สำเร็จ", "เปลี่ยนรูปโปรไฟล์ไม่สำเร็จ", "?page=profile", "2000", "false");
            }
        }
    }
    ?>
    <!--Bootstrap JavaScript Libraries-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>