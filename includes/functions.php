<?php

// filter the text to stay a bit safe from potiential threats
function normal_text($data)
{
    if (gettype($data) !== "array") {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    return '';
}

// returing the original text back
function normal_text_back($text)
{
    if (gettype($text) !== "array") {
        return htmlspecialchars_decode(trim($text), ENT_QUOTES);
    }
    return '';
}

// returns the date into more of a human readable
function normal_date($date, $format = 'M d, Y h:i A')
{
    $d = date_create($date);
    return date_format($d, $format);
}

// returns the current date based on set timezone
function current_date($format = 'Y-m-d H:i:s')
{
    return date($format);
}

function go($url)
{
    header("location: " . $url);
    die();
}

function get_ip() {  
    /* if share internet */
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    /* if proxy */
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    /* if remote address */
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;
}  


// get settings from the database and put them as associative array
function get_settings ()
{
    global $db;

    $s = $db->prepare("SELECT * FROM `tbl_settings`");
    if (!$s->execute()) {
        return false;
    }
    $rows = $s->fetchAll();

    $data = [];
    foreach ($rows as $row) {
        $data[$row['setting_name']] = $row['setting_value'];
    }
    return $data;
}

// get a specific setting from the global settings array
function get_setting ($name)
{
    global $settings;
    if (array_key_exists($name, $settings)) {
        return $settings[$name];
    }
    return '';
}

// update the specific settings
function update_setting ($name, $value)
{
    global $db;
    $s = $db->prepare("UPDATE `tbl_settings` SET `setting_value` = :v WHERE `setting_name` = :n");
    $s->bindParam(":n", $name);
    $s->bindParam(":v", $value);
    return $s->execute();
}

function key_status($val)
{
    if ($val === 'A') {
        return 'Active';
    }
    if ($val === 'U') {
        return 'Inactive';
    }
    if ($val === 'B') {
        return 'Blocked';
    }
    return "";
}
