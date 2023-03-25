<?php
if (empty($_SESSION['user'])) {
    rdr('?page=login', 0);
} else {
    // do nothing...
    $user = $_GET['user'];
}

if (query("SELECT * FROM `user` WHERE `user_name` = '$user'")->rowCount() == 0) {
    $api->alert->alertMessage("warning", "ไม่พบผู้ใช้", "คุณพยายามกรอกชื่อของ User นี้เองหรือป่าว ลองไปค้นหาผ่านหน้า Home แล้วกดลิ้งก์เข้ามานะ", "?page=home", "1200", "false");
}
?>
<!doctype html>
<html lang="en">

<head>
    <title><?php echo "Preview " . $_GET['user']; ?>'s Profile</title>
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
        $profile = query("SELECT * FROM `user` WHERE `user_name` = '$user'")->Fetch();
        // Join table between user and membership
        $membership = query("SELECT * FROM `user` JOIN `membership` ON `user`.`user_membership` = `membership`.`membership_reference` WHERE `user_name` = '$user'")->Fetch();
        $membership_next = query("SELECT * FROM `membership` WHERE `membership_reference` = '$membership[membership_reference]' + 1")->Fetch();
        ?>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="<?php echo $profile['user_avatar']; ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <br>
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
            </div>
        </div>
    </div>
    <script>
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
    </script>
    <!--Bootstrap JavaScript Libraries-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>