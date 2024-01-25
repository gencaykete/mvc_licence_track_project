<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password'];
    function get_user($id) {
        $u = $this->asArray()->where('id', $id)->find();
        return count($u) > 0 ? $u[0] : null;
    }
    function get_total_user_count() {
        return $this->db->table($this->table)->countAllResults();
    }
    function check_user($email, $password) {
        $u = $this->asArray()->where(array('email' => $email, 'password' => md5($password)))->find();
        return count($u) > 0 ? $u[0] : null;
    }
}
?>