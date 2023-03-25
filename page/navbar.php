<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark p-0 mb-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="?page=home"><img class="img-fluid" width="85" height="96" src="https://kittisakwebsite.epizy.com/dist/image/uploader_logo_2.png" alt=""></a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-sm-0">
                <?php if (isset($_SESSION['user'])) { ?>
                    <li class="nav-item me-1">
                        <a class=" btn btn-outline-warning" href="?page=upload" data-bs-toggle="tooltip" data-bs-placement="top" title="อัปโหลดรูปภาพ"><i class="fas fa-upload    "></i> อัปโหลดรูปภาพ</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item me-1">
                        <button class=" btn btn-outline-warning cannot-upload" data-bs-toggle="tooltip" data-bs-placement="top" title="โปรดเข้าสู่ระบบก่อน"><i class="fas fa-lock    "></i> อัปโหลดรูปภาพ</button>
                    </li>

                    <?php } ?>&nbsp;

                    <li class="nav-item">
                        <a class="btn btn-light" href="?page=home" aria-current="page"  data-bs-toggle="tooltip" data-bs-placement="top" title="กลับหน้าหลัก"><i class="fas fa-home    "></i> Home </a>
                    </li>

            </ul>

            <form class="d-flex mb-2 mt-2 my-lg-0" action="" method="post" id="search-bar">
                <input class="form-control" type="text" name="tag" id="tag" placeholder="ค้นหาด้วย #tag หรือ @user" required>&nbsp;
                <button class="btn btn-outline-primary my-2 my-sm-0 text-nowrap" type="submit" id="search-tag" name="search-tag"><i class="fas fa-search"></i> ค้นหา</button>
            </form>


            <!-- Switch between with session and without session -->
            <ul class="navbar-nav mt-sm-0 ms-auto">
                <div class="">
                    <?php if (isset($_SESSION['user'])) { ?>
                        <div class="d-flex my-2 my-lg-0">
                            <a href="?page=profile" class="btn btn-primary me-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="โปรไฟล์ของคุณ"><i class="fas fa-user-circle"></i> โปรไฟล์</a>
                            <a href="?page=logout" class="btn btn-danger" onclick="return confirmLogout()"  data-bs-toggle="tooltip" data-bs-placement="top" title="ออกจากระบบ"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex my-2 my-lg-0">
                            <a href="?page=login" class="btn btn-outline-success me-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="เข้าสู่ระบบ"><i class="fas fa-sign-in-alt    "></i> เข้าสู่ระบบ</a>
                            <a href="?page=register" class="btn btn-success"  data-bs-toggle="tooltip" data-bs-placement="top" title="สมัครสมาชิก"><i class="fas fa-user-plus    "></i> ลงทะเบียน</a>
                        </div>
                    <?php } ?>
                </div>
            </ul>
        </div>
    </div>
</nav>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่ว่าต้องการออกจากระบบ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ออกจากระบบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with logout
                window.location.href = "?page=logout";
                return true;
            } else {
                // Cancel logout
                return false;
            }
        })

        // Prevent link from navigating immediately
        return false;
    }

    $(".cannot-upload").click(function() {
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
            title: 'โปรดเข้าสู่ระบบก่อน'
        })
    });
</script>