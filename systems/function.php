<?php
// Redirect
function rdr($url, $time)
{
    echo "<script type='text/javascript'>
		setTimeout(function()
            {
                location.href = '$url';
            }, $time);
</script>";
}

// Encode password
function encode($password)
{
    $en = sha1($password);

    return $en;
}

// Query
function query($sql, $array = array())
{
    global $api;
    $q = $api->sql->prepare($sql);
    $q->execute($array);
    return $q;
}

// Clear all session
function clear_session()
{
    session_unset();
    session_destroy();
}

// Get current date in Thai format
function DateThai()
{
    $strDate = date("F j, Y, g:i a");
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

function randomName($length)
{   
    $lens = $length;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $lens; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        // Check if $randomString is already in database
        $check = query("SELECT * FROM `uploader_image` WHERE `img_name` = '$randomString'")->rowCount();
        if ($check > 0) {
            randomName($lens);
        } else {
            $imageRandomName = $randomString;
        }
    }
    return $imageRandomName;
}