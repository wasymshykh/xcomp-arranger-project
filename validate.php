<?php

require_once 'config/init.php';
$k = new Key($db);

if (isset($_GET['code']) && !empty($_GET['code']) && is_string($_GET['code'])) {
    $request_data = $_GET['code'];
    if (!empty($request_data)) {

        // checking if data is in correct format

        $request_data_split = explode(' ', normal_text($request_data));
        // filtering array
        for ($i = 0; $i < count($request_data_split); $i++) {
            $request_data_split[$i] = normal_text($request_data_split[$i]);
            if (empty($request_data_split[$i])) {
                unset($request_data_split[$i]);
            }
        }

        if (count($request_data_split) === 3) {
            
            // adding data to variables
            $email = $request_data_split[0];
            $serial = $request_data_split[1];
            $str = $request_data_split[2];
            $fingerprint = $str;

            // finding if serial is available

            $s = new Serial($db);
            
            $_serial_data = $s->get_serial_by('serial_code', $serial);
            

            if ($_serial_data['status']) {
                if ($_serial_data['message']) {
                    $_serial_data = $_serial_data['message'];

                    if (empty($_serial_data['serial_email']) || $_serial_data['serial_email'] === $email) {

                        // if serial is used then it will checked against fingerprint in database
                        if ($_serial_data['serial_status'] === 'U') {

                            $check = $k->get_key_by('key_serial', $_serial_data['serial_code']);
                            if ($check['status']) {
                                $ip = get_ip();
                                if ($check['message'] === false) {
                                    $k->record_failure($_serial_data['serial_id'], $ip, "Cannot find record against used serial code.");
                                    http_response_code(509);
                                    die();
                                }
                                $_key_data = $check['message'];

                                if ($_key_data['key_fingerprint'] === $fingerprint) {
                                    
                                    echo $_key_data['key_key'];
                                    http_response_code(200);
                                    die();
                                    
                                } else {
                                    $k->record_failure($_key_data['key_id'], $ip, "Requested key again with different fingerprint.");
                                    http_response_code(509);
                                    die();
                                }

                            }
                            
                            die ('cool');
                            
                        } else if ($_serial_data['serial_status'] === 'A') {
                            // if serial is unused then key will be generated against fingerprint and stored in the database, serial is then set to used
        
                            SWP_Initialize(0x81645732, 0x19573549);
                            $key = XCBC($str);
                            
                            // checking if the generated key is valid in length
                            if (!(strlen($key) > 16)) {
        
                                $check = $k->get_key_by('key_fingerprint', $fingerprint);

                                if ($check['status']) {
                                    $ip = get_ip();
                                    
                                    if ($check['message'] !== false) {
                                        // key is already in the database
                                        
                                        // recording the failure
                                        $k->record_failure($check['message']['key_id'], $ip, "Key was already existed in the database");
                                        
                                        // returning 509 response
                                        http_response_code(509);
                                        die();
                                    }

                                    // inserting key into the database
                                    $result = $k->insert($fingerprint, $email, $serial, $key, $ip);
                                    if ($result['status']) {
                                        // data is successfully inserted
                                            // returning the key to user with status code of 200

                                        // updating serial status
                                        $s->update_serial_status('U', $_serial_data['serial_id']);

                                        if (empty($_serial_data['serial_email'])) {
                                            $s->update_serial_email($email, $_serial_data['serial_id']);
                                        }

                                        echo $key;
                                        http_response_code(200);
                                        die();

                                    } else {
                                        // unable to execute query
                                        // returning status code 500
                                        http_response_code(500);
                                        die();
                                    }
                                    
                                } else {
                                    // unable to execute query
                                        // returning status code 500
                                    http_response_code(500);
                                    die();
                                }
        
                            }
                            
                        }

                    }

                }
            } else {
                // unable to execute query
                    // returning status code 500
                http_response_code(500);
                die();
            }
        }

    }
}

// returning error for invalid request
    // 403 code is returned
http_response_code(403);
die();


function XCBC($str)
{
    global $str, $u, $v, $l0, $l1, $m0, $m1;
    $u = 0;
    $v = 0;
    $str = bin2hex($str);

    // full length intermediate message blocks
    $flimbs = ceil(strlen($str) / 16) - 1;

    for ($i = 0; $i < $flimbs; $i += 1) {
        XCBCstep();
    }

    if (strlen($str) == 16) {
        $u = $u ^ $l0;
        $v = $v ^ $l1;

        XCBCstep();
    } else {
        $u = $u ^ $m0;
        $v = $v ^ $m1;

        $str = $str . "100000000000000";

        XCBCstep();
    }


    $u = dechex($u);
    $v = dechex($v);
    while (strlen($u) < 8) {
        $u = '0' . $u;
    }
    while (strlen($v) < 8) {
        $v = '0' . $v;
    }

    return $u . $v;
}

function XTEA()
{
    global $u, $v, $key;
    $s = 0;
    $d = 0x9e3779b9;
    for ($i = 0; $i < 32; $i++) {
        $u = _add($u, _add($v << 4 ^ _rshift($v, 5), $v) ^ _add($s, $key[$s & 3]));
        $s =  ($s + $d);
        $s = 0xffffffff & $s;
        $v = _add($v, _add($u << 4 ^ _rshift($u, 5), $u) ^ _add($s, $key[_rshift($s, 11) & 3]));
    }
    return;
}

function XCBCstep()
{
    global $u, $v, $str;
    $p = substr($str, 0, 8);
    $q = substr($str, 8, 8);
    $str = substr($str, 16);
    $p = hexdec($p);
    $q = hexdec($q);
    $u = $u ^ $p;
    $v = $v ^ $q;
    XTEA();
    return;
}

function _add($i1, $i2)
{
    $result = 0.0;
    foreach (func_get_args() as $value) {
        if (0.0 > $value) {
            $value -= 1.0 + 0xffffffff;
        }
        $result += $value;
    }


    // convert to 32 bits
    if (0xffffffff < $result || -0xffffffff > $result) {
        $result = fmod($result, 0xffffffff + 1);
    }

    // convert to signed integer
    if (0x7fffffff < $result) {
        $result -= 0xffffffff + 1.0;
    } elseif (-0x80000000 > $result) {
        $result += 0xffffffff + 1.0;
    }

    return $result;
}

function hex2b3in($h)
{
    if (!is_string($h)) return null;
    $r = '';
    for ($a = 0; $a < strlen($h); $a += 2) {
        $r .= chr(hexdec($h{$a} . $h{($a + 1)}));
    }
    return $r;
}

function _rshift($integer, $n)
{
    // convert to 32 bits
    if (0xffffffff < $integer || -0xffffffff > $integer) {
        $integer = fmod($integer, 0xffffffff + 1);
    }

    // convert to unsigned integer
    if (0x7fffffff < $integer) {
        $integer -= 0xffffffff + 1.0;
    } elseif (-0x80000000 > $integer) {
        $integer += 0xffffffff + 1.0;
    }

    // do right shift
    if (0 > $integer) {
        $integer &= 0x7fffffff;                     // remove sign bit before shift
        $integer >>= $n;                            // right shift
        $integer |= 1 << (31 - $n);                 // set shifted sign bit
    } else {
        $integer >>= $n;                            // use normal right shift
    }

    return $integer;
}

function SWP_Initialize($mk0 = 0x11111111, $mk1 = 0x22222222, $mk2 = 0x33333333, $mk3 = 0x44444444, $ml0 = 0x12345678, $ml1 = 0x12345678, $mm0 = 0x87654321, $mm1 = 0x87654321)
{
    global $l0, $l1, $m0, $m1, $key;

    $key[0] = $mk0;
    $key[1] = $mk1;
    $key[2] = $mk2;
    $key[3] = $mk3;

    $l0 = $ml0;
    $l1 = $ml1;

    $m0 = $mm0;
    $m1 = $mm1;

    return;
}
