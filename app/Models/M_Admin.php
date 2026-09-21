<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Admin extends Model
{
    protected $table = 'tbl_admin';

    public function getDataAdmin(array $where =[]){
        $builder =$this->db->table($this->table)->select('*')->orderBy('nama_admin','ASC');

        if(!empty($where)){
         $builder->where($where);
        }
        return $builder->get();
    }

    public function saveDataAdmin($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataAdmin($data, $where)
    {
        return $this->db->table($this->table)->where($where)->update($data);
        

    }

    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_admin");
        $builder->orderBy("id_admin", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
    }
}
?>