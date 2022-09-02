<?php
defined('BASEPATH') or exit('No direct script access allowed');


require 'vendor/autoload.php';
use Dompdf\Dompdf;

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Barang_model', 'barang');
        $this->load->model('Supiler_model', 'suppiler');
        $this->load->model('Konsumen_model', 'konsumen');
        $this->load->model('Report_model', 'report');
        is_logged_in();
    }
// ------------------------------------------------------------Barang-----------------------------------------------------------------------
    public function index()
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $config['base_url'] = 'http://localhost/admin-graha/laporan/index';
        if ( $this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
            $data['cetak'] = $this->input->post('keyword');
        }else {
            $data['keyword']= $this->session->userdata('keyword');
            $data['cetak'] = 0;
        }         

        $array = array('idkategori' =>  $data['keyword']);
        $this->db->from('barang'); 
        $this->db->or_like($array);
        // $this->db->or_having('nm_barang',  $data['keyword']);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 13;
        
        //inisialisasi
        $this->pagination->initialize($config);
        
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->report->getbarangbykategory($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    
    }

    public function alldata(){
        $this->session->unset_userdata('keyword');
        redirect('laporan');
    }

    public function reportBarang($id){     
        $data['title'] = 'Report Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $data['report'] = $this->report->getCetakBarang($id);
        $html = $this->load->view('laporan/print_barang', $data,TRUE);
        if ($id > 0) {
            $namadocument = 'Laporan Barang';
            $dompdf = new Dompdf();
            $old_limit = ini_set("memory_limit","120M");
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream($namadocument,array('Attachment'=>0));
            exit(0);            
        }else {
            $this->load->view('laporan/print_barang', $data);
            
        }
    }

    public function datapelanggan(){
        $data['title'] = 'Data Pelangan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
    
        $config['base_url'] = 'http://localhost/admin-graha/laporan/datapelanggan';
        if ($this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('konsumen', $data['keyword']);
        }else {
            $data['keyword']= $this->session->userdata('konsumen');
        } 
    
        $this->db->like('nm_konsumen',$data['keyword']);
        $this->db->or_like('alamat',$data['keyword']);
        $this->db->or_like('no_telp',$data['keyword']);
        $this->db->from('konsumen');
    
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 10;
        
        //inisialisasi
        $this->pagination->initialize($config);     
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->konsumen->getKonsumen($config['per_page'], $data['start'],$data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/data_konsumen', $data);
        $this->load->view('templates/footer');
    }

    public function reportKonsumen(){     
        $data['title'] = 'Report Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $data['report'] = $this->report->getCetakKonsumen();
        $html = $this->load->view('laporan/print_konsumen', $data,TRUE); 
        $namadocument = 'Laporan Barang';
        $dompdf = new Dompdf();
        $old_limit = ini_set("memory_limit","120M");
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($namadocument,array('Attachment'=>0));
        exit(0);            
       
    }

    public function datapembelian(){
        $data['title'] = 'Data Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();   
        $data['nota_beli'] = $this->report->getNota();
        $data['pilihan'] =0;  
        $data['pilih'] = 0;          
        $config['base_url'] = 'http://localhost/admin-graha/laporan/datapembelian';
        if ($this->input->post('tgl_msk')) {
            $data['keyword']= $this->input->post('tgl_msk');
            $data['pilih'] = 1;
            $this->session->set_userdata('pilih', $data['pilih']);
            $this->session->set_userdata('keyword', $data['keyword']);
        }
        else {
            $data['keyword']= $this->session->userdata('keyword');
        }
        
        if ($this->input->post('nonota')) {
            $data['keyword']= $this->input->post('nonota');
            $data['pilih'] = 2;
            $this->session->set_userdata('pilih', $data['pilih']);
            $this->session->set_userdata('keyword', $data['keyword']);           
        } else {
            $data['keyword']= $this->session->userdata('keyword');
        }
      
        if ($this->input->post('jns')) {
            $data['keyword']= $this->input->post('jns');
            $data['pilih'] = 3;
            $this->session->set_userdata('pilih', $data['pilih']);
            $this->session->set_userdata('keyword', $data['keyword']);           
        } else {
            $data['keyword']= $this->session->userdata('keyword');
        }
    
        $this->db->like('tgl_masuk',$data['keyword']);  
        $this->db->or_like('no_notabeli',$data['keyword']);
        $this->db->or_like('jenis',$data['keyword']);
        $this->db->from('pembelian');
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 10;
        
        //inisialisasi
        $this->pagination->initialize($config);     
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->report->getPembelian($config['per_page'], $data['start'],$data['keyword'],$data['pilih']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/data_pembelian', $data);
        $this->load->view('templates/footer');
    }

    public function alldataPembelian(){
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('pilih');
        redirect('laporan/datapembelian');
    }

    public function reportPembelian(){     
        $data['title'] = 'Report Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();

        $data['keyword'] = $this->session->userdata('keyword');
        $data['pilih'] = $this->session->userdata('pilih');
       
        $data['report'] = $this->report->getCetakPembelian($data['keyword'], $data['pilih']);
        $html = $this->load->view('laporan/print_pembelian', $data,TRUE); 
        $namadocument = 'Laporan Barang';
        $dompdf = new Dompdf();
        $old_limit = ini_set("memory_limit","120M");
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($namadocument,array('Attachment'=>0));
        exit(0);            
       
    }



    
    
}