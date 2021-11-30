<?php
class Voucher_model extends CI_Model
{
    public function saveData($data)
    {
        if ($this->db->insert('voucher_table', $data)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function add_voucher($date, $invoiceid, $vendor, $user, $path, $gst, $cgst, $sgst, $finalamt)
    {
        $sql = "INSERT INTO `vouchers`(`vender_id`, `invoice_no`, `user_id`, `gst`, `sgst`, `cgst`, `total`, `uploadurl`, `date`, `status`) 
        VALUES ($vendor, $invoiceid,$user,'$gst','$sgst','$cgst','$finalamt','$path','$date',0)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
