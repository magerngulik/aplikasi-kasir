<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Recovery_model extends CI_Model
{


    public function getPembelian($limit,$start){

        $this->db->select('*');
        $this->db->from('pembelian a'); 
        $this->db->join('pembelian_detail b', 'a.no_pembelian=b.no_pembelian', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('supplier d', 'a.idsupplier=d.idsupplier', 'left');
        $this->db->order_by('c.idbarang','DESC');
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
     }




}