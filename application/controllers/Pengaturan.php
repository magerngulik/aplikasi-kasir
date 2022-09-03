<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Barang_model', 'barang');
        $this->load->model('Supiler_model', 'suppiler');
        $this->load->model('Konsumen_model', 'konsumen');
        $this->load->model('Report_model', 'report');
        $this->load->model('Recovery_model', 'pengaturan');
        $this->load->dbutil();
        is_logged_in();
       
    }
    public function index(){
        $data['title'] = 'Recovery Pembelian';
        $this->load->library('pagination');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();   
        $data['pilih'] = 0;          
        $config['base_url'] = 'http://localhost/admin-graha/pengaturan/index';
        $config['total_rows'] =$this->db->get('pembelian')->num_rows(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 12;       
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->pengaturan->getPembelian($config['per_page'], $data['start']);
        $this->pagination->initialize($config);     
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/index', $data);
        $this->load->view('templates/footer');
    }

    public function recoverPembelian($nota,$idbarang){

 
       $pembelianDetail= $this->db->get_where('pembelian_detail', ['no_pembelian' => $nota,'idbarang' => $idbarang])->row_array();
       $barang= $this->db->get_where('barang', ['idbarang' => $idbarang])->row_array();
       $jumlah = $pembelianDetail['jumlah']; 
       $stok =  $barang['stok'];
       $kurangStok = $stok - $jumlah;

       $this->db->where('idbarang',$idbarang);
       $this->db->update('barang',['stok' => $kurangStok]);
       $this->db->delete('pembelian_detail',  ['no_pembelian' => $nota,'idbarang' => $idbarang]);
       $cek= $this->db->get_where('pembelian_detail', ['no_pembelian' => $nota])->row_array(); 
       if ($cek == FALSE ) {
           $this->db->delete('pembelian',  ['no_pembelian' => $nota]);
       }     
       $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil di Hapus!</div>');
       redirect('pengaturan/');
    }


}