<?php

class UserDetail
{
    private $user_id;
    private $mobile;
    private $email;
    public function sessionCheck($conn)
    {
        if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_mobile']) && isset($_SESSION['admin_email'])) {
            $this->user_id = $_SESSION['admin_id'];
            $this->mobile = $_SESSION['admin_mobile'];
            $this->email = $_SESSION['admin_email'];
            $qry = "SELECT * FROM admin WHERE id=:user_id AND mobile=:mobile AND email=:email";
            $qry_prepare = $conn->prepare($qry);
            $qry_exec = $qry_prepare->execute([":user_id" => $this->user_id, ":mobile" => $this->mobile, ":email" => $this->email]);
            if ($qry_prepare->rowCount() == 1) {
                return "logged_in";
            } else {
                return "not_exist";
            }
        } else {
            return "not_logged_in";
        }
    }
    public function uniqAlpha()
    {
        $data = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $x = '';
        for ($i = 0; $i < 16; $i++) {
            $rand = rand(0, 25);
            $x .= $data[$rand];
        }
        return $x;
    }
    public function txnAmt($conn, $user)
    {
        $txn_type_cr = $conn->prepare("SELECT SUM(amt) AS txn_type_cr FROM transaction WHERE user_id=:user_id AND txn_type=:txn_type AND txn_status=:txn_status");
        $txn_type_cr->execute([":user_id" => $user, ":txn_type" => "cr", ":txn_status" => "success"]);
        $fetch_txn_cr = $txn_type_cr->fetchAll();

        $txn_type_dr = $conn->prepare("SELECT SUM(amt) AS txn_type_dr FROM transaction WHERE user_id=:user_id AND txn_type=:txn_type AND txn_status=:txn_status");
        $txn_type_dr->execute([":user_id" => $user, ":txn_type" => "dr", ":txn_status" => "success"]);
        $fetch_txn_dr = $txn_type_dr->fetchAll();

        $wallet_rem = $fetch_txn_cr[0]['txn_type_cr'] - $fetch_txn_dr[0]['txn_type_dr'];
        return number_format((float)$wallet_rem, 2, '.', '');
    }
    public function totalTxn($conn, $user, $txn_type, $txn_status)
    {
        if ($txn_type == 'cr' && $txn_status == 'success') {
            $condition = " AND txn_type=:txn_type AND txn_status = :txn_status";
            $execute = [":user_id" => $user, ":txn_type" => $txn_type, ":txn_status" => $txn_status];
        }
        else if($txn_type == 'dr' && $txn_status == 'success'){
            $condition = " AND txn_type=:txn_type AND txn_status = :txn_status";
            $execute = [":user_id" => $user, ":txn_type" => $txn_type, ":txn_status" => $txn_status];
        }else if($txn_type == 'cr' && $txn_status == 'failed'){
            $condition = " AND txn_type=:txn_type AND txn_status = :txn_status";
            $execute = [":user_id" => $user, ":txn_type" => $txn_type, ":txn_status" => $txn_status];
        } else{
            $condition = " ";
            $execute = [":user_id" => $user];
        }
        $total_txn = $conn->prepare("SELECT COUNT(*) AS total FROM transaction WHERE user_id=:user_id " . $condition);
        $total_txn->execute($execute);
        $fetch_total = $total_txn->fetchAll();
        return $fetch_total[0]['total'];
    }
}
