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
    
    public function getNoPenjualan($id){
        // SELECT * FROM `penjualan` a JOIN konsumen b on a.idpelanggan = b.idpelanggan
        $this->db->select('*');
        $this->db->from('penjualan a'); 
        $this->db->join('konsumen b', 'a.idpelanggan=b.idpelanggan', 'left');
        $this->db->where('a.no_nota',$id);
        return $this->db->get()->row_array();  
    }

}
