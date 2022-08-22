<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Supiler_model extends CI_Model
{
    // supplier idsupplier	nm_supplier	alamat	no_telp	kontak

    public function getSupplier($limit,$start,$keyword=null){     
        $this->db->order_by('idsupplier','DESC'); 
        if ($keyword) {
            $this->db->like('nm_supplier',$keyword);
            $this->db->or_like('alamat',$keyword);
            $this->db->or_like('no_telp',$keyword);
            $this->db->or_like('kontak',$keyword);           
        }
        $this->db->limit($limit,$start);
        return $this->db->get("supplier")->result_array(); 
    }

    public function countAllSupiler(){
        return $this->db->get("supplier")->num_rows();
    }
  
    public function cariBarangPagging($limit,$start,$keyword){
        $keyword = $this->input->post('keyword');
        $this->db->select('*');
        $this->db->like('nm_supplier',$keyword);
        $this->db->or_like('alamat',$keyword);
        $this->db->or_like('no_telp',$keyword);
        $this->db->or_like('kontak',$keyword);
        return $this->db->get('supplier',$limit,$start)->result_array();       
    }

    public function deleteData($id= null,$tabel = null , $idName){
        $this->db->where($idName,$id);
        $this->db->delete($tabel);
    }
    //salah
    public function getTotalSuppiler(){
        $this->db->select_sum('nm_supplier');
        return $this->db->get('supplier')->row_array();
    }

    public function getSuppilerBy($id){
        return  $this->db->get_where('supplier', ['idsupplier' => $id])->row_array();
    }
}
