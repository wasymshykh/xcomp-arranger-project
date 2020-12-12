<?php

// class contains all the functions related to database and key
class Key
{
    
    private $db;
    private $table;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->table = 'tbl_keys';
    }

    //  checking for the key in the database
        // @col - name of the db column
        // @val - value that is trying to match
        // @multiple (optional) - return multiple rows if true
    public function get_key_by ($col, $val, $multiple = false)
    {
        $q = "SELECT * FROM `{$this->table}` WHERE `$col` = '$val' AND `key_deleted` = 'N'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            if ($multiple) {
                return $this->_r(true,  $s->fetchAll());
            }
            return $this->_r(true,  $s->fetch());
        }
        return $this->_r(false, "Unable to execute the query");
    }

    public function get_keys ()
    {
        $q = "SELECT * FROM `{$this->table}` WHERE `key_deleted` = 'N'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    // update the key status
    public function update_key_status ($status, $key_id)
    {
        $q = "UPDATE `{$this->table}` SET `key_status` = :s WHERE `key_id` = :k";
        $s = $this->db->prepare($q);
        $s->bindParam(":s", $status);
        $s->bindParam(":k", $key_id);
        return $s->execute();
    }

    // update the key deleted
    public function update_key_deleted ($key_id)
    {
        $q = "UPDATE `{$this->table}` SET `key_deleted` = 'Y' WHERE `key_id` = :k";
        $s = $this->db->prepare($q);
        $s->bindParam(":k", $key_id);
        return $s->execute();
    }

    public function insert($fingerprint, $key, $ip)
    {
        $q = "INSERT INTO `{$this->table}` (`key_fingerprint`, `key_key`, `key_created_on`, `key_created_ip`) VALUE (:f, :k, :c, :i)";
        $s = $this->db->prepare($q);
        $s->bindParam(":f", $fingerprint);
        $s->bindParam(":k", $key);
        $datetime = current_date();
        $s->bindParam(":c", $datetime);
        $s->bindParam(":i", $ip);
        if ($s->execute()) {
            return $this->_r(true,  "Key is successfully inserted");
        }
        return $this->_r(false, "Unable to execute the query");
    }

    public function record_failure($key_id, $ip, $desc)
    {
        $q = "INSERT INTO `tbl_keys_failed` (`failed_key_id`, `failed_ip`, `failed_description`, `failed_created_on`) VALUE (:k, :i, :d, :c)";
        $s = $this->db->prepare($q);
        $s->bindParam(":k", $key_id);
        $s->bindParam(":i", $ip);
        $s->bindParam(":d", $desc);
        $datetime = current_date();
        $s->bindParam(":c", $datetime);
        if ($s->execute()) {
            return $this->_r(true,  "Failure is successfully inserted");
        }
        return $this->_r(false, "Unable to execute the query");
    }

    // returns the message and status as an associative array
    private function _r ($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }

}

