<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{
    public function getLastData(){

        // $query = mysqli_query($db_link, "select * from kategori");
        // $a = mysqli_query($db_link, "SELECT * from barang order by idbarang DESC");
        // $row = mysqli_fetch_array($a);        
    }

    public function getCountIdBarang($idKategori){
        $this->db->select('COUNT(idbarang) as total', false);
        $this->db->from('barang');
        $this->db->where('barang.idkategori',$idKategori);
        return $this->db->get()->row_array(); 
    }

    public function getKategoriBy($id){
        return  $this->db->get_where('kategori', ['idkategori' => $id])->row_array();
    }

    public function getSumAssets(){
        $this->db->select('SUM(hrg_modal * stok) as total', false);
        $this->db->from('barang');
        return $this->db->get()->row_array(); 
    }

    public function getSumStock(){
            $this->db->select('SUM(stok) as total', false);
            $this->db->from('barang');
            return $this->db->get()->row_array(); 
    }

    public function getBarang($limit,$start,$keyword=null){

        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        if ($keyword) {
            // $search = str_replace('/\s\s+/','%',$keyword);
            $this->db->like('nm_barang', $keyword);
            $this->db->or_like('hrg_modal', $keyword);  

        }
        return $this->db->get($limit,$start)->result_array();
        
    }
    
    public function allkategori(){
        $this->db->order_by('idkategori', 'desc');
        return $this->db->get('kategori')->result_array();
    }

    public function getBarangById($id){
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        $this->db->where('a.idbarang',$id);
        return $this->db->get()->row_array();   
    }
}
