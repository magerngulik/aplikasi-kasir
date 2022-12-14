<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function getbarangbykategory($limit,$start,$keyword=null){
        
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        $this->db->order_by('idbarang','DESC');
        if ($keyword) {
            $this->db->like('a.idkategori',$keyword);
                 
        }
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
    }
    
    public function getStokMinus($limit,$start,$keyword=null){
        
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        $this->db->order_by('idbarang','DESC');
        $this->db->where('a.stok < "0"');
        if ($keyword) {
            $this->db->like('a.idkategori',$keyword);
        }
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
    }

    public function getCetakStokMinus($keyword = null){
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        $this->db->where('a.stok < "0"');
        if ($keyword > 0) {
            $this->db->like('a.idkategori',$keyword);
        }
        return $this->db->get()->result_array(); 
    }

    public function getCetakBarang($keyword = null){
        $this->db->select('*');
        $this->db->from('barang a'); 
        $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
        if ($keyword > 0) {
            $this->db->like('a.idkategori',$keyword);
        }
        return $this->db->get()->result_array(); 
    }

    public function getCetakKonsumen(){    
        $this->db->order_by('idpelanggan','ASC'); 
        return $this->db->get("konsumen")->result_array(); 
    }

     public function getPembelian($limit,$start,$keyword=null,$pilih){
        $this->db->select('*');
        $this->db->from('pembelian a'); 
        $this->db->join('pembelian_detail b', 'a.no_pembelian=b.no_pembelian', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('supplier d', 'a.idsupplier=d.idsupplier', 'left');
        $this->db->order_by('a.tgl_masuk','DESC');
        $this->db->order_by('a.no_pembelian','DESC');
        if ($pilih == 1) {
            $this->db->like('a.tgl_masuk',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_notabeli',$keyword);
        } elseif ($pilih ==3)  {
            $this->db->like('a.jenis',$keyword);
        }
        
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
     }

     public function getNota(){
        $this->db->select('*');
        $this->db->from('pembelian'); 
        return $this->db->get()->result_array();
     }



    public function getCetakPembelian($keyword = null,$pilih =null){
        $this->db->select('*');
        $this->db->from('pembelian a'); 
        $this->db->join('pembelian_detail b', 'a.no_pembelian=b.no_pembelian', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('supplier d', 'a.idsupplier=d.idsupplier', 'left');
        $this->db->order_by('c.idbarang','DESC');
        if ($pilih == 1) {
            $this->db->like('a.tgl_masuk',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_notabeli',$keyword);
        } elseif ($pilih ==3)  {
            $this->db->like('a.jenis',$keyword);
        }
        return $this->db->get()->result_array(); 
    }

// ---------------------------------------------------------------------report penjualan----------------------------------------------------------------------------------------------------

    public function getNotaPenjualan(){
        $this->db->select('no_nota');
        $this->db->from('penjualan'); 
        return $this->db->get()->result_array();
     }

    public function getPenjualan($limit,$start,$keyword=null,$pilih=null){
        $this->db->select('*');
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('konsumen d', 'a.idpelanggan=d.idpelanggan', 'left');
        $this->db->order_by('a.tgl_nota','DESC');
        $this->db->order_by('a.no_nota','DESC');
        if ($pilih == 0) {
            $date = date("Y/m/d");
            $this->db->like('a.tgl_nota',$date);
        }elseif ($pilih == 1) {
            $this->db->like('a.tgl_nota',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_nota',$keyword);
        }
        $this->db->limit($limit,$start);
        return $this->db->get()->result_array(); 
     }

     public function getCetakPenjualan($keyword = null,$pilih =null){
        $this->db->select('*');
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('konsumen d', 'a.idpelanggan=d.idpelanggan', 'left');
        $this->db->order_by('c.idbarang','DESC');
        if ($pilih == 1) {
            $this->db->like('a.tgl_nota',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_nota',$keyword);
        }
        return $this->db->get()->result_array(); 
    }




    public function getSumTjual($keyword = null,$pilih =null){
        $this->db->select('SUM(harga_jual * jumlah) as total');
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('konsumen d', 'a.idpelanggan=d.idpelanggan', 'left');
        if ($pilih == 0) {
            $date = date("Y/m/d");
            $this->db->like('a.tgl_nota',$date);
        }
        elseif ($pilih == 1) {
            $this->db->like('a.tgl_nota',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_nota',$keyword);
        }
        return $this->db->get()->row_array(); 
    }

    public function getSumData($keyword = null,$pilih =null){
        $this->db->select('SUM(laba) as laba');
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('konsumen d', 'a.idpelanggan=d.idpelanggan', 'left');
        if ($pilih == 0) {
            $date = date("Y/m/d");
            $this->db->like('a.tgl_nota',$date);
        }
        elseif ($pilih == 1) {
            $this->db->like('a.tgl_nota',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_nota',$keyword);
        }
        return $this->db->get()->row_array(); 
    }


    
    public function getDataRecovery($keyword = null,$pilih =null){
        $this->db->select('*');
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->join('barang c', 'b.idbarang=c.idbarang', 'left');
        $this->db->join('konsumen d', 'a.idpelanggan=d.idpelanggan', 'left');
        $this->db->order_by('c.idbarang','DESC');
        if ($pilih == 1) {
            $this->db->like('a.tgl_nota',$keyword);
        }elseif ($pilih ==2) {
            $this->db->like('a.no_nota',$keyword);
        }
        return $this->db->get()->result_array(); 
    }


}

