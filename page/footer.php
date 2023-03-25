<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
    <footer class="footer mt-auto py-2 mb-0 bg-dark fixed-bottom text-light mt-3">
            <div class="text-center">
                <span class="text-light">&copy; Uploader's Project 2023 | For Education Purpose Only | </span>
                <button type="button" class="btn btn-danger btn-sm " id="btn-back-to-top" data-bs-toggle="tooltip" data-bs-placement="top" title="กลับชึ้นด้านบน">
                    <i class="fas fa-arrow-up"></i> 
                </button> 
                <?php if($_SESSION['admin'] === "true") { ?> | <button type="button" class="btn btn-danger btn-sm" onclick="return goToBackend('<?php echo $user; ?>')" ><i class="fas fa-cogs"></i> Backend</button> <?php } ?>
            </div>
            
        </footer>
    </div>
</body>
<script>
    // Back to top button function
    //Get the button
    let mybutton = document.getElementById("btn-back-to-top");

    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    // Redirect to backed
    function goToBackend($user) {
            Swal.fire({
                title: '<strong>เรากำลังพาคุณไปหน้า Backend</strong>',
                icon: 'info',
                text: 'กำลังเปลี่ยนหน้า...',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                timer: 2000,
                timerProgressBar: true,

            });
            setTimeout(function() {
                window.location.href = "?page=backend";
            }, 2000);
        }
</script>

</html>