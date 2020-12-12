<?php

// class contains all the functions related to database and payment
class Pay
{
    
    private $db;
    private $table;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->table = 'tbl_payments';
    }

    public function insert($id, $paidAmount, $currency, $payerID, $payerName, $payerEmail, $payerCountryCode, $state)
    {
        $cols = "(`payment_txn_id`, `payment_gross`, `payment_currency_code`, `payment_payer_id`, `payment_payer_name`, `payment_payer_email`, `payment_payer_country`, `payment_payer_status`, `payment_created_on`)";
        $vals = "(:tx, :pg, :pc, :pi, :pn, :pe, :pct, :ps, :dt)";

        $s = $this->db->prepare("INSERT INTO `{$this->table}` $cols VALUE $vals");
        $s->bindParam(":tx", $id);
        $s->bindParam(":pg", $paidAmount);
        $s->bindParam(":pc", $currency);
        $s->bindParam(":pi", $payerID);
        $s->bindParam(":pn", $payerName);
        $s->bindParam(":pe", $payerEmail);
        $s->bindParam(":pct", $payerCountryCode);
        $s->bindParam(":ps", $state);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        $s->execute();
    }

    public function get_payment_by ($col, $val, $multiple = false)
    {
        $q = "SELECT * FROM `{$this->table}` WHERE `$col` = '$val' AND `payment_deleted` = 'N'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

}
