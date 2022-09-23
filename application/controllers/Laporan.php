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
        include_once APPPATH . '/third_party/fpdf/fpdf.php';
    }
// ------------------------------------------------------------Barang-----------------------------------------------------------------------

public function index()
    {
        $base = base_url();        
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $config['base_url'] = $base.'/laporan/index';
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
        // $html = $this->load->view('laporan/print_barang', $data,TRUE);


        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddPage();
        $pdf->Cell(191, 7, 'Stok Barang', '0', '1', 'C');
        $pdf->Cell(191, 7, 'Graha Bangunan', '0', '1', 'C');
        $pdf->Cell(191, 7, '', '0', '1', 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 8, 'Pekanbaru, ', '0', '0', 'R');
        $pdf->Cell(30, 8, date('d-M-Y'), '0', '1', 'L');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(100, 149, 237);
        $pdf->Cell(30, 8, 'ID Barang', '1', '0', 'C', true);
        $pdf->Cell(65, 8, 'Nama Barang', '1', '0', 'C', true);
        $pdf->Cell(23, 8, 'Harga Beli', '1', '0', 'C', true);
        $pdf->Cell(23, 8, 'Harga Jual', '1', '0', 'C', true);
        $pdf->Cell(15, 8, 'Stok', '1', '0', 'C', true);
        $pdf->Cell(35, 8, 'Kategori', '1', '1', 'C', true);
        $totalstok = 0;
        $totalaset = 0;
        foreach ($data['report']  as $row) { 

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 6, $row['idbarang'], '1', '0', 'C');
            $pdf->Cell(65, 6, $row['nm_barang'], '1', '0', 'C');
            $pdf->Cell(23, 6, $row['hrg_modal'], '1', '0', 'C');
            $pdf->Cell(23, 6, $row['hrg_satuan'], '1', '0', 'C');
            $pdf->Cell(15, 6, $row['stok'], '1', '0', 'C');
            $pdf->Cell(35, 6, $row['nm_kategori'], '1', '1', 'C');

            if ($row['stok'] > 0) {
                $a = $row['hrg_satuan'] * $row['stok'];
                $totalaset = $totalaset + $a;
                $totalstok = $totalstok + $row['stok'];
            }
        }
        $pdf->Cell(15, 8, '', '0', '1', 'C');
        $pdf->Cell(15, 8, 'Total Stok ', '0', '0', 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(35, 8, $totalstok, '0', '1', 'C', true);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(15, 8, 'Total Aset ', '0', '0', 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(35, 8, "Rp $totalaset", '0', '1', 'C', true);
        $pdf->Output();

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
        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddPage();
        $pdf->Cell(191, 7, 'Daftar Konsumen', '0', '1', 'C');
        $pdf->Cell(191, 7, 'Graha Bangunan', '0', '1', 'C');
        $pdf->Cell(191, 7, '', '0', '1', 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 8, 'Pekanbaru, ', '0', '0', 'R');
        $pdf->Cell(30, 8, date('d-M-Y'), '0', '1', 'L');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(100, 149, 237);
        $pdf->Cell(30, 8, 'ID Pelanggan', '1', '0', 'C', true);
        $pdf->Cell(65, 8, 'Nama Pelanggan', '1', '0', 'C', true);
        $pdf->Cell(65, 8, 'Alamat', '1', '0', 'C', true);
        $pdf->Cell(25, 8, 'No Telp', '1', '1', 'C', true);
        foreach ($data['report']  as $row) { 
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 6, $row['idpelanggan'], '1', '0', 'C');
            $pdf->Cell(65, 6, $row['nm_konsumen'], '1', '0', 'C');
            $pdf->Cell(65, 6, $row['alamat'], '1', '0', 'C');
            $pdf->Cell(25, 6, $row['no_telp'], '1', '1', 'C');
        }
        $pdf->Output();
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
        $this->db->from('pembelian a'); 
        $this->db->join('pembelian_detail b', 'a.no_pembelian=b.no_pembelian', 'left');
        $this->db->like('a.tgl_masuk',$data['keyword']);  
        $this->db->or_like('a.no_notabeli',$data['keyword']);
        $this->db->or_like('a.jenis',$data['keyword']);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 10;
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

        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddPage();
        $pdf->Cell(191, 7, "Laporan Pembelian", '0', '1', 'C');
        $pdf->Cell(191, 7, 'Graha Bangunan', '0', '1', 'C');
        $pdf->Cell(191, 7, '', '0', '1', 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, 'Tanggal Cetak :  ', '0', '0', 'R');
        $pdf->Cell(30, 8, 'Pekanbaru, ', '0', '0', 'R');
        $pdf->Cell(30, 8, date('d-M-Y'), '0', '1', 'L');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(100, 149, 237);
        $pdf->Cell(34, 10, 'No Nota', '1', '0', 'C', true);
        $pdf->Cell(33, 10, 'Tgl Masuk', '1', '0', 'C', true);
        $pdf->Cell(57, 10, 'Konsumen', '1', '0', 'C', true);
        $pdf->Cell(28, 10, 'Jenis', '1', '0', 'C', true);
        $pdf->Cell(38, 10, 'Total', '1', '1', 'C', true);
        $total = 0;
        foreach ($data['report']  as $row) { 
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(34, 6, $row['no_notabeli'], '1', '0', 'C');
            $pdf->Cell(33, 6, $row['tgl_masuk'], '1', '0', 'C');
            $pdf->Cell(57, 6, $row['nm_supplier'], '1', '0', 'C');
            $pdf->Cell(28, 6, $row['jenis'], '1', '0', 'C');
            $pdf->Cell(38, 6, $total = $row['jumlah'] * $row['harga_beli'], '1', '1', 'C');
        }
        $pdf->Output();     
    }


    public function datapenjualan(){
        $data['title'] = 'Data Penjualan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();   
        $data['nota_beli'] = $this->report->getNotaPenjualan();  
        $data['pilihjual'] = 0;          
        $config['base_url'] = 'http://localhost/admin-graha/laporan/datapenjualan';

        if ($this->input->post('tgl_msk')) {
            $data['key']= $this->input->post('tgl_msk');
            $data['pilihjual'] = 1;     
            $this->session->set_userdata('pilihjual', $data['pilihjual']);
            $this->session->set_userdata('key', $data['key']);
            $config['total_rows'] =0;
            $data['start']=0;
        }
        else {
            $data['key']= $this->session->userdata('key');
        }
        if ($this->input->post('no_nota')) {
            $data['key']= $this->input->post('no_nota');
            $data['pilihjual'] = 2;
            $this->session->set_userdata('pilihjual', $data['pilihjual']);
            $this->session->set_userdata('key', $data['key']); 
            $config['total_rows'] =0;
            $data['start']=0;          
        } else {
            $data['key']= $this->session->userdata('key');
        }
        
        $this->db->from('penjualan a'); 
        $this->db->join('penjualan_detail b', 'a.no_nota=b.no_nota', 'left');
        $this->db->or_like('a.tgl_nota',$data['key']);
        $this->db->or_like('a.no_nota',$data['key']);
        $config['total_rows'] = $this->db->count_all_results(); ;
        $config['per_page'] = 10;
        $data['total_rows'] = $config['total_rows']; 
        
        //inisialisasi
        $this->pagination->initialize($config);     
        $data['total_jual'] =$this->report->getSumTjual($data['key'],$data['pilihjual']);
        $data['total_laba'] =$this->report->getSumData($data['key'],$data['pilihjual']);
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->report->getPenjualan($config['per_page'], $data['start'],$data['key'],$data['pilihjual']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/data_penjualan', $data);
        $this->load->view('templates/footer');
    }


    public function reportPenjualan(){     
        $data['title'] = 'Report Penjualan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();

        $data['key'] = $this->session->userdata('key');
        $data['pilihjual'] = $this->session->userdata('pilihjual');
        $data['report'] = $this->report->getCetakPenjualan($data['key'], $data['pilihjual']);   
        $pilih = $data['pilihjual'];
        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddPage();
        $pdf->Cell(191, 7, 'Laporan Penjualan', '0', '1', 'C');
        $pdf->Cell(191, 7, 'Graha Bangunan', '0', '1', 'C');
        $pdf->Cell(191, 7, '', '0', '1', 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, 'Tanggal Cetak :  ', '0', '0', 'R');
        $pdf->Cell(30, 8, 'Pekanbaru, ', '0', '0', 'R');
        $pdf->Cell(30, 8, date('d-M-Y'), '0', '1', 'L');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(100, 149, 237);
        $pdf->Cell(20, 10, 'Tgl Nota', '1', '0', 'C', true);
        $pdf->Cell(55, 10, 'Nama Barang', '1', '0', 'C', true);
        $pdf->Cell(28, 10, 'Harga Jual', '1', '0', 'C', true);
        $pdf->Cell(28, 10, 'Qty', '1', '0', 'C', true);
        $pdf->Cell(28, 10, 'Total', '1', '0', 'C', true);
        $pdf->Cell(28, 10, 'Laba', '1', '1', 'C', true);

        $total = 0;
        $gtotal = 0;
        $glaba = 0;
        foreach ($data['report']  as $row) {
            $total = $total + $row['laba'];
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(20, 6, $row['tgl_nota'], '1', '0', 'C');
            $pdf->Cell(55, 6, $row['nm_barang'], '1', '0', 'C');
            $pdf->Cell(28, 6, $row['harga_jual'], '1', '0', 'C');
            $pdf->Cell(28, 6, $row['jumlah'], '1', '0', 'C');
            $pdf->Cell(28, 6, $total = $row['harga_jual'] * $row['jumlah'], '1', '0', 'C');
            $pdf->Cell(28, 6, $row['laba'], '1', '1', 'C');
            $gtotal = $gtotal + $total;
            $glaba = $glaba + $row['laba'];
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(43, 6, '', '0', '1', 'C');
        $pdf->Cell(46, 6, "Total Penjualan", '0', '0', 'L');
        $pdf->Cell(46, 6, "Rp. $gtotal", '0', '1', 'L');
        $pdf->Cell(46, 6, "Total Laba", '0', '0', 'L');
        $pdf->Cell(46, 6, "Rp. $glaba", '0', '1', 'L');
        $pdf->Output();

    }

    public function alldataPenjualan(){
        $this->session->unset_userdata('key');
        $this->session->unset_userdata('pilihjual');
        redirect('laporan/datapenjualan');
    }

    
    public function stokminus()
    {
        $data['title'] = 'Stok Minus Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $config['base_url'] = 'http://localhost/admin-graha/laporan/stokminus';
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
        $this->db->where('stok < "0"');
        $this->db->or_like($array);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 13;
        
        //inisialisasi
        $this->pagination->initialize($config);
        
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->report->getStokMinus($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/data_stok_minus', $data);
        $this->load->view('templates/footer');
    }

    public function alldataStokMinus(){
        $this->session->unset_userdata('keyword');
        redirect('laporan/stokminus');
    }
    public function reportStokMinus($id){     
        $data['title'] = 'Report Stok Minus';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();        
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $data['kategori'] = $this->barang->allkategori();
        $data['report'] = $this->report->getCetakStokMinus($id);
        $html = $this->load->view('laporan/print_stok_minus', $data,TRUE);  
        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddPage();
        $pdf->Cell(191, 7, 'Stok Barang Minus', '0', '1', 'C');
        $pdf->Cell(191, 7, 'Graha Bangunan', '0', '1', 'C');
        $pdf->Cell(191, 7, '', '0', '1', 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 8, 'Pekanbaru, ', '0', '0', 'R');
        $pdf->Cell(30, 8, date('d-M-Y'), '0', '1', 'L');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setFillColor(100, 149, 237);
        $pdf->Cell(30, 8, 'ID Barang', '1', '0', 'C', true);
        $pdf->Cell(65, 8, 'Nama Barang', '1', '0', 'C', true);
        $pdf->Cell(23, 8, 'Harga Beli', '1', '0', 'C', true);
        $pdf->Cell(23, 8, 'Harga Jual', '1', '0', 'C', true);
        $pdf->Cell(15, 8, 'Stok', '1', '0', 'C', true);
        $pdf->Cell(35, 8, 'Kategori', '1', '1', 'C', true);
        foreach ($data['report']  as $row) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 6, $row['idbarang'], '1', '0', 'C');
            $pdf->Cell(65, 6, $row['nm_barang'], '1', '0', 'C');
            $pdf->Cell(23, 6, $row['hrg_modal'], '1', '0', 'C');
            $pdf->Cell(23, 6, $row['hrg_satuan'], '1', '0', 'C');
            $pdf->Cell(15, 6, $row['stok'], '1', '0', 'C');
            $pdf->Cell(35, 6, $row['nm_kategori'], '1', '1', 'C');
        }
        $pdf->Output();

    }

    public function backup(){
        $this->load->dbutil();
        $db_name = 'backup-db'.$this->db->database.'-on'.date("Y-m-d-H-i-s").'.sql';
        $prefs = array(
            'format' => 'zip',
            'filename' => $db_name,
            'add_insert' => TRUE,
            'foreign_key_checks' => FALSE
        );
        $backup = $this->dbutil->backup($prefs);
        $save = 'pathtpbkfolder'.$db_name;
        $this->load->helper('file');
        write_file($save,$backup);
        $this->load->helper('download');
        force_download($db_name,$backup);
    }

  
}