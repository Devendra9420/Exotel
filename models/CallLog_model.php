<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 *	@author : Irfan shaikh
 *  @support: irfan@digitalflake.com
 *	date	: 22 November, 2021
 *  version: 1.0
*/

class CallLog_model extends CI_Model
{
    public function addCallLog($data)
    {
        $query = $this
            ->db
            ->insert('call_history', $data);
    }

    /*
     *	@author : Devendra Patil
     *  @support: devendra@digitalflake.com
     *	date	: 25 November, 2021
     *  version: 1.0
    */
    public function get_callhistory($fdate, $tdate)
    {
        $sql = "SELECT ch.id as id, ch.call_to, ch.call_from,  date(ch.date) as date, time(ch.date) as time, ifnull(c.name, '') as customer_name, ifnull(c.channel, '') as channel, ifnull(bk.latest_booking_id, '') as latest_booking_id,
        ifnull(bk.latest_booking_date, '-') as latest_booking_date, ifnull(bk1.status, '') as booking_status, ch.comment as comment, ch.purpose_of_call as purpose_of_call
        FROM call_history ch
        left join customer c on ch.call_from = c.mobile
        left join (select customer_id, ifnull(max(booking_id), '-') as latest_booking_id, ifnull(max(created_on), '-') as latest_booking_date from bookings group by customer_id)bk on c.customer_id = bk.customer_id
        left join bookings bk1 on bk1.booking_id = bk.latest_booking_id Where date(ch.date) between '$fdate' and '$tdate';";
        $query = $this
            ->db
            ->query($sql);
        return $query->result_array();
    }
    public function update_call_history($id, $data)
    {
        $sql = "UPDATE call_history SET ";
        foreach ($data as $key => $value) {
            $sql .=  $key . " = " . $value . ", ";
        }
        $sql = trim($sql, ' ');
        $sql = trim($sql, ',');
        $sql .= "WHERE id = '$id'";
        $query = $this->db->query($sql);
        return $query;
    }
}
