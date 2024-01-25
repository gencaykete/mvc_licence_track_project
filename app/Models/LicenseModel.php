<?php namespace App\Models;

use CodeIgniter\Model;

class LicenseModel extends Model
{
    protected $table = 'licenses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product', 'license_key', 'domain', 'type', 'until'];
    function get_valid_licenses_count() {
        return $this->db->table($this->table)->where('(until > '.time().') OR (until = 0)')->countAllResults();
    }
    function get_license_by_id($id) {
        $d = $this->db->table($this->table)->where("id", $id)->get()->getResultArray();
        return count($d) > 0 ? $d[0] : null;
    }
    function check_license($domain, $product) {
        return $this->db->table($this->table)->where('((domain = "'.trim($domain).'") AND (product = "'.$product.'")) AND ((until > '.time().') OR (until = 0))')->countAllResults()>0;
    }
    function check_license_by_key($domain, $key) {
        return $this->db->table($this->table)->where('((domain = "'.trim($domain).'") AND (license_key = "'.$key.'")) AND ((until > '.time().') OR (until = 0))')->countAllResults()>0;
    }
}
?>