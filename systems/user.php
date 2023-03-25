<?php
class User
{
    public function Register($user_name, $user_password, $user_email, $user_phone)
    {
        global $api;

        // Check Username for already  existed!
        $i = query("SELECT * FROM `user` WHERE `user_name` = '$user_name' OR `user_email` = '$user_email'")->rowCount();
        if ($i == 0) {

            // Format to Thai format
            $dateTime = DateThai();

            // Get Timestamp
            $timestamp = time();

            // Encode Password with SHA1 algorithm
            $encode_password = encode($user_password);

            //Insert Data to Database
            query("INSERT INTO `user` (`user_name`, `user_password`, `user_email`, `user_phone`, `user_membership`, `create_time`) VALUES ('$user_name', '$encode_password', '$user_email', '$user_phone', '0', '$dateTime')");

            // Return response success message
            return $api->alert->alertMessage("success", "ลงทะเบียนสำเร็จ", "You can login and start you journey", "?page=login", "10000", "true");
        } else {
            // Return response error message
            return $api->alert->alertMessage("error", "ลงทะเบียนไม่สำเร็จ", "ชื่อผู้ใช้หรือ", "?page=register", "2000", "true");
        }
    }


    // Function Login
    public function Login($user_email, $user_password)
    {
        global $api;
        // Encode password with SHA1 algorithm
        $encode_password = encode($user_password);

        // Check Username && password
        $i = query("SELECT * FROM `user` WHERE `user_email` = '$user_email' AND `user_password` = '$encode_password'")->rowCount();
        $j = query("SELECT * FROM `user` WHERE `user_email` = '$user_email' AND `user_password` = '$encode_password'")->fetch(PDO::FETCH_ASSOC);
        // Return response with information
        if ($i == 1) {
            $_SESSION['user'] = $j['user_name'];
            $_SESSION['admin'] = $j['user_admin_status'];
            return $api->alert->alertMessage("success", "เข้าสู่ระบบสำเร็จ", "กำลังพาไปหน้าหลัก...", "?page=home", "2000", "true");
        } else {
            return $api->alert->alertMessage("error", "เข้าสู่ระบบไม่สำเร็จ", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง", "?page=login", "2000", "true");
        }
    }

    public function Logout()
    {
        global $api;
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        $api->alert->alertMessage("success", "ดำเนินการสำเร็จ", "กำลังกลับสู่หน้าหลัก", "?page=home", "1200", "true");
    }

    public function checkMembership($user_name)
    {
        global $api;
        // Join user and membership table
        $i = query("SELECT * FROM `user` INNER JOIN `membership` ON `user`.`user_membership` = `membership`.`membership_reference` WHERE `user_name` = '$user_name'")->fetch(PDO::FETCH_ASSOC);
        // Check if EXP is = or > current membership_exp
        if ($i['user_exp'] >= $i['membership_exp']) {

            // Get Current Membership
            $current_membership = $i['user_membership'];

            // Get Next Membership
            $next_membership = $current_membership + 1;

            // Update membership and remove exp
            // Get current EXP
            $current_exp = $i['user_exp'];

            // Get current membership exp
            $current_membership_exp = $i['membership_exp'];

            // minus current exp and current membership exp
            $minus_exp = $current_exp - $current_membership_exp;

            // Stop if membership is 4
            if ($current_membership == 4) {
                # do nothing
            } else {
                // Get current membership name and + next membership name
                query("UPDATE `user` SET `user_membership` = '$next_membership', `user_exp` = '$minus_exp' WHERE `user_name` = '$user_name'");
                
                $g = query("SELECT * FROM `membership` WHERE `membership_reference` = '$next_membership'")->fetch();
                $current_membership_name = $g['membership_name'];
                $api->alert->alertMessage("info", "ยินดีด้วย", "คุณได้เลื่อนขั้นเป็น $current_membership_name", "?page=profile", "1200", "false");
            }
        }
    }

    // Function changePassword
    public function changePassword($username, $present_password, $new_password)
    {
        global $api;
        // Fetch Data feom Database
        $i = query("SELECT * FROM `user` WHERE `user_name` = '$username'")->fetch();

        // Encode password
        $encode_present_password = encode($present_password);

        // Encode Password
        $encode_new_password = encode($new_password);

        // Check password
        if ($encode_present_password === $i['user_password']) {
            // If true Update new password
            query("UPDATE `user` SET `user_password` = '$encode_new_password' WHERE `user_name` = '$username'");

            // Show message response success
            $api->alert->alertMessage("success", "เปลี่ยนรหัสผ่านสำเร็จ", "", "?page=profile", "3000", "false");
        } else {
            // If false Show message response error
            $api->alert->alertMessage("error", "เปลี่ยนรหัสผ่านไม่สำเร็จ", "รหัสผ่านปัจจุบันผิด", "?page=profile", "3000", "false");
        }
    }

    // Function changeProfile avatar, email, phone
    public function changeProfile($user, $email, $phone) 
    {
        global $api;
        // Check if email or phone is empty
        if (empty($email) || empty($phone)) {
            // If true show message response error
            $api->alert->alertMessage("error", "เปลี่ยนข้อมูลส่วนตัวไม่สำเร็จ", "กรุณากรอกข้อมูลให้ครบถ้วน", "?page=profile", "3000", "false");
        } else {
            // If false update data to database
            query("UPDATE `user` SET `user_email` = '$email', `user_phone` = '$phone'" . "WHERE `user_name` = '$user'");

            // Show message response success
            $api->alert->alertMessage("success", "เปลี่ยนข้อมูลส่วนตัวสำเร็จ", "", "?page=profile", "3000", "false");
        }
        
    }

    public function checkUserIsLiked($user, $img_id)
    {
        global $api;
        // Get user id from user
        $user_id = $this->getUserID($user);
        $i = query("SELECT * FROM `like` WHERE `user_id` = '$user_id' AND `img_id` = '$img_id'")->rowCount();
        if ($i == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserID($user)
    {
        global $api;
        $i = query("SELECT * FROM `user` WHERE `user_name` = '$user'")->fetch(PDO::FETCH_ASSOC);
        return $i['user_id'];
    }

    public function getNumberOfLikes($img_id) 
    {
        global $api;
        $i = query("SELECT * FROM `uploader_image` WHERE `img_id` = '$img_id'")->fetch();
        return $i['img_like'];
    }
    


}
