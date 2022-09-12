<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Konsumen_model extends CI_Model
{
    // konsumen idpelanggan	nm_konsumen	alamat no_telp
    public function getKonsumen($limit,$start,$keyword=null){    
        $this->db->order_by('idpelanggan','ASC'); 
        if ($keyword) {
            $this->db->like('nm_konsumen',$keyword);
            $this->db->or_like('alamat',$keyword);
            $this->db->or_like('no_telp',$keyword);    
        }
        $this->db->limit($limit,$start);
        return $this->db->get("konsumen")->result_array(); 
    }

    public function countAllKonsumen(){
        return $this->db->get("konsumen")->num_rows();
    }
  
    public function cariKonsumenPagging($limit,$start,$keyword){
        $keyword = $this->input->post('keyword');
        $this->db->select('*');
        $this->db->like('nm_konsumen',$keyword);
        $this->db->or_like('alamat',$keyword);
        $this->db->or_like('no_telp',$keyword);
        return $this->db->get('konsumen',$limit,$start)->result_array();       
    }

    public function deleteData($id= null,$tabel = null , $idName){
        $this->db->where($idName,$id);
        $this->db->delete($tabel);
    }
    //salah
    public function getTotalKonsumen(){
        $this->db->select_sum('nm_konsumen');
        return $this->db->get('konsumen')->row_array();
    }

    public function getKonsumenBy($id){
        return  $this->db->get_where('konsumen', ['idpelanggan' => $id])->row_array();
    }
}
