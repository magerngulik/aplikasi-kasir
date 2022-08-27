<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    public function getNopembelian($id){
        $this->db->select('*');
        $this->db->from('pembelian a'); 
        $this->db->join('supplier b', 'a.idsupplier=b.idsupplier', 'left');
        $this->db->where('a.no_pembelian',$id);
        return $this->db->get()->row_array();   
    }
}
