<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="">
    <section class="gradient-custom">
        <div class="container py-1 mb-5 pt-5 ">
            <div class="row d-flex justify-content-center align-items-center pt-3">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 pt-3">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-3 text-center">
                            <form action="" method="post">

                            
                            <div class="mb-md-3 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase"><i class="fas fa-door-open    "></i> login portal</h2>
                                <p class="text-white-50 mb-5">โปรดใส่อีเมลล์และรหัสผ่านของคุณเพื่อเข้าสู่ระบบ
                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="email"><i class="fas fa-envelope    "></i> Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="อีเมล" required/>
                                </div>

                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="password"><i class="fas fa-lock    "></i> Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="รหัสผ่าน" required/>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit"><i class="fas fa-sign-in-alt    "></i> เข้าสู่ระบบ</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $api->user->Login($email, $password);
        }
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>