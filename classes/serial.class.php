<?php

// class contains all the functions related to database and serial
class Serial
{
    
    private $db;
    private $table;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->table = 'tbl_serials';
    }

    public function get_serials ()
    {
        $q = "SELECT * FROM `{$this->table}` WHERE `serial_status` != 'D'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_serial_by ($col, $val, $multiple = false)
    {
        $q = "SELECT * FROM `{$this->table}` WHERE `$col` = '$val' AND `serial_status` != 'D'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            if ($multiple) {
                return $this->_r(true,  $s->fetchAll());
            }
            return $this->_r(true,  $s->fetch());
        }
        return $this->_r(false, "Unable to execute the query");
    }

    public function insert($code, $email)
    {
        $q = "INSERT INTO `{$this->table}` (`serial_code`, `serial_email`, `serial_created_on`) VALUE (:co, :e, :c)";
        $s = $this->db->prepare($q);
        $s->bindParam(":co", $code);
        $s->bindParam(":e", $email);
        $datetime = current_date();
        $s->bindParam(":c", $datetime);
        if ($s->execute()) {
            return $this->_r(true,  "Serial code is successfully inserted");
        }
        return $this->_r(false, "Unable to execute the query");
    }

    // update the serial status
    public function update_serial_status ($status, $serial_id)
    {
        $q = "UPDATE `{$this->table}` SET `serial_status` = :s WHERE `serial_id` = :k";
        $s = $this->db->prepare($q);
        $s->bindParam(":s", $status);
        $s->bindParam(":k", $serial_id);
        return $s->execute();
    }
    
    // update the serial email
    public function update_serial_email ($email, $serial_id)
    {
        $q = "UPDATE `{$this->table}` SET `serial_email` = :e WHERE `serial_id` = :k";
        $s = $this->db->prepare($q);
        $s->bindParam(":e", $email);
        $s->bindParam(":k", $serial_id);
        return $s->execute();
    }

    // generating random serial that is not in the database
    public function generate_unqiue_serial ()
    {
        $failure = 0;
        $nonunique = 0;
        $got = false;
        while (!$got) {
            $generated_code = $this->random_serial();
            $r = $this->get_serial_by('serial_code', $generated_code);
            if ($r['status']) {
                if (!$r['message']) {
                    return $this->_r(true, $generated_code);
                } else {
                    $nonunique += 1;
                }
            } else {
                $failure += 1;
            }

            if ($failure > 15 || $nonunique > 160) {
                return $this->_r(false, "Resource limit exceeded while generating code.");
            }
        }
    }
    private function random_serial ($length=12, $chars='0123456789') {
        $str_arr = [];
        $max = mb_strlen($chars, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str_arr []= $chars[random_int(0, $max)];
        }
        return implode('', $str_arr);
    }

    // returns the message and status as an associative array
    private function _r ($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }

}

