<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ";
        return $this->db->query($query)->result_array();
    }
    
    public function deleteData($id= null,$tabel = null , $idName){
        $this->db->where($idName,$id);
        $this->db->delete($tabel);
    }
    
    public function getMenuById($id){
        $this->db->select('*');
        $this->db->from('user_sub_menu a'); 
        $this->db->join('user_menu b', 'a.menu_id=b.id', 'left');
        $this->db->where('a.id',$id);
        return $this->db->get()->row_array();
    }
    
    public function getMenuId($id){
        $this->db->select('*');
        $this->db->from('user_menu'); 
        $this->db->where('id',$id);
        return $this->db->get()->row_array();
    }

    public function getSiswa(){
            $this->db->select('*');
            $this->db->from('data_siswa a');
            $this->db->join('data_kelas b', 'a.id_kelas=b.id_kelas', 'left');
            return $this->db->get()->result_array();
    }
    public function getPoin(){
            $this->db->select('*');
            $this->db->from('data_siswa a');
            $this->db->join('data_kelas b', 'a.id_kelas=b.id_kelas', 'left');
            $this->db->join('data_kelas c', 'a.id_kelas=b.id_kelas', 'left');
            return $this->db->get()->result_array();
    }

    public function getDataPelangaran(){
      return  $this->db->get('data_pelangaran')->result_array();
    }    


    public function getDataPelangaranID($id){
        return  $this->db->get_where('data_pelangaran', ['id_pelangaran' => $id])->row_array();
    }


    public function getBarang($limit,$start,$keyword=null){
        
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        $this->db->order_by('idbarang','DESC');
        if ($keyword) {
            $this->db->like('nm_barang',$keyword);
            $this->db->or_like('idbarang',$keyword);           
        }
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
    }

    public function countAllBarang(){
        return $this->db->get("barang")->num_rows();
    }

    public function getTotalBarang(){

        $this->db->select_sum('stok');
        return $this->db->get('barang')->row_array();
    }
    
    public function cariBarangPagging($limit,$start,$keyword){
        $keyword = $this->input->post('keyword');
        $this->db->select('*');
        $this->db->like('nm_barang',$keyword);
        $this->db->or_like('hrg_modal',$keyword);
        $this->db->or_like('hrg_satuan',$keyword);
        $this->db->or_like('stok',$keyword);
        return $this->db->get('barang',$limit,$start)->result_array();
        
    }

}
