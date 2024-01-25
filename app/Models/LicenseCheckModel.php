<?php namespace App\Models;

use CodeIgniter\Model;

class LicenseCheckModel extends Model
{
    protected $table = 'checks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['license_key', 'url', 'server_ip', 'user_ip', 'times', 'status', 'time'];
    function get_warnings_count() {
        return $this->db->table($this->table)->where(array('status' => -1))->countAllResults();
    }
    function get_last_ten_day() {
        $date = strtotime(date('Y-m-d', strtotime('-10 day')));
        return $this->asArray()->where('time >= '.$date)->findAll();
    }
}
?>