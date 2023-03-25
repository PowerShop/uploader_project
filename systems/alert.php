<?php
class Alert
{
    public function alertMessage($icon, $title, $message, $link, $time, $progress)
    {
        global $api;
        // default $progress = true
        if ($progress == "true") {
            $progress = "true";
            $confirmButton = "false";
            $timer = "timer";
        } else {
            $progress = "false";
            $confirmButton = "true";
            $timer = "t";
        }
        echo "<script type='text/javascript'>
			Swal.fire({
				icon: '$icon',
				title: '$title',
				html: '$message',
				$timer: $time,
				timerProgressBar: $progress,
				showConfirmButton: $confirmButton,
				allowEscapeKey: 'false',
				allowEnterKey: 'false',
				allowOutsideClick: () => {
					const popup = Swal.getPopup()
					popup.classList.remove('swal2-show')
					setTimeout(() => {
					popup.classList.add('animate__animated', 'animate__headShake')
					})
					setTimeout(() => {
					popup.classList.remove('animate__animated', 'animate__headShake')
					}, 500)
					return false
				}
			}).then((result) => {
                if (result.isConfirmed) {
                    location.href = '$link';
                }
            });
            </script>";
        if ($progress == "false") {
            # do nothing...
        } else {
            echo "<script type='text/javascript'>
            setTimeout(function(){
						location.href = '$link';
						}, $time);
					</script>";
        }
    }
}
