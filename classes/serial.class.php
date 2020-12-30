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

    // returns the message and status as an associative array
    private function _r ($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }

}

