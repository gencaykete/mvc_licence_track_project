<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'prefix'];
    function get_total_products_count() {
        return $this->db->table($this->table)->countAllResults();
    }
    function get_product_by_id($id) {
        $d = $this->db->table($this->table)->where("id", $id)->get()->getResultArray();
        return count($d) > 0 ? $d[0] : null;
    }
}
?>