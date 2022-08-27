<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Barang_model', 'barang');
        $this->load->model('Supiler_model', 'suppiler');
        $this->load->model('Konsumen_model', 'konsumen');
        $this->load->model('Transaksi_model', 'transaksi');
    }

    public function index(){
        $config['base_url'] = 'http://localhost/admin-graha/transaksi/index/';
        
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('suppiler', $data['keyword']);
        }else {
            $data['keyword']= $this->session->userdata('suppiler');
        } 
        $this->db->like('nm_supplier',$data['keyword']);
        $this->db->or_like('alamat',$data['keyword']);
        $this->db->or_like('no_telp',$data['keyword']);
        $this->db->or_like('kontak',$data['keyword']);   
        $this->db->from('supplier');
    
        $config['total_rows'] =$this->db->count_all_results();  
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 9;
        
        //inisialisasi
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->suppiler->getSupplier($config['per_page'], $data['start'],$data['keyword']);
        $this->pagination->initialize($config);     
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
        
    }

    public function pembelian($id){
    
        $data['title'] = 'Input Nota Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['kategori'] = $this->suppiler->getSuppilerBy($id);
        $data['jenis'] = $this->suppiler->getSuppilerBy($id);

        $this->form_validation->set_rules('no_nota', 'No Nota', 'required|trim',['required' =>'No Nota Tidak boleh kosong']);
        $this->form_validation->set_rules('nm_supplier', 'Nama Suppiler', 'required|trim');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required|trim' ,['required' =>'Jenis harus di pilih']);
        $this->form_validation->set_rules('tgl_msk', 'Tanggal Masuk', 'required|trim',['required' =>'Tanggal Masuk harus di pilih']);
        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaksi/pembelian', $data);
            $this->load->view('templates/footer');
        } else {          
            $basicformat = "BL00000";
            $num = $this->db->count_all_results('pembelian', FALSE); 
            $katnumber = (int)$num + 1;
            $hasikKategori="";             
            if($katnumber <10){
                $hasikKategori = "00".(string) $katnumber;
            }else
            if ($katnumber <100) {
                $hasikKategori = "0".(string) $katnumber;   
            }else
            if($katnumber >=100){
                $hasikKategori = $katnumber;
            }    
            $id = $basicformat.$hasikKategori;
            $data = [
                'no_pembelian' => $id,
                'no_notabeli' => $this->input->post('no_nota'),
                'idpegawai' => $this->input->post('id_pegawai'),
                'idsupplier' => $this->input->post('idsupplier'),
                'jenis' => $this->input->post('jenis'),
                'tgl_masuk' => $this->input->post('tgl_msk'),
                'catatan' => ''
            ];
            $this->db->insert('pembelian',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nota berhasil buat!</div>');
            $this->session->set_userdata('detailid', $id);
            redirect('transaksi/detailPembelian/');
        }
        
    }

    public function detailPembelian(){
        // getNopembelian
        $id = $this->session->userdata('detailid');
        $data['nota_pembelian'] = $this->transaksi->getNopembelian($id);
        $data['cart']= $this->cart->contents();
        $data['title'] = 'Input Detail Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['kategori'] = $this->suppiler->getSuppilerBy($id);
        $data['jenis'] = $this->suppiler->getSuppilerBy($id);
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();

        $config['base_url'] = 'http://localhost/admin-graha/transaksi/detailPembelian/';
        if ( $this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        }else {
            $data['keyword']= $this->session->userdata('keyword');
        }         

        $array = array('idbarang' =>  $data['keyword'], 'nm_barang' =>  $data['keyword']);
        $this->db->from('barang'); 
        $this->db->or_like($array);
        // $this->db->or_having('nm_barang',  $data['keyword']);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 5;
        
        //inisialisasi
        $this->pagination->initialize($config);
        
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->menu->getBarang($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaksi/input_detail', $data);
        $this->load->view('templates/footer');
        
    }

    public function iddatabarang($id){
        $this->session->set_userdata('idbarang', $id);
        redirect('transaksi/inputDetail');
    }

    public function delidbarang(){
        $this->session->unset_userdata('idbarang');
        redirect('transaksi/detailPembelian/');
    }


     public function inputDetail(){
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['idbarang'] = $this->session->userdata('idbarang');
        $data['ketbarang'] = $this->db->get_where('barang', ['idbarang' => $data['idbarang']])->row_array();
        $data['title'] = 'Input Jumlah Barang';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $id = $this->session->userdata('detailid');
        $data['nota_pembelian'] = $this->transaksi->getNopembelian($id);

        $this->form_validation->set_rules('nm_barang', 'No Nota', 'required|trim',['required' =>'No Nota Tidak boleh kosong']);
        $this->form_validation->set_rules('hrg_modal', 'Nama Suppiler', 'required|trim');
        $this->form_validation->set_rules('stok', 'Jenis', 'required|trim' ,['required' =>'Jenis harus di pilih']);
        $this->form_validation->set_rules('hrg_beli', 'Tanggal Masuk', 'required|trim|numeric',['required' =>'Tanggal Masuk harus di pilih', 'numeric' => 'Harus berisi data angka']);   
        $this->form_validation->set_rules('jml_beli', 'Tanggal Masuk', 'required|trim|numeric',['required' =>'Tanggal Masuk harus di pilih','numeric' => 'Harus berisi data angka']);   

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaksi/jumlah_beli', $data);
            $this->load->view('templates/footer');
        } else {        
            $data = array(
                'id' => $this->input->post('id'),
                'price' => 0,
                'name' => 'barang', 
                'qty' => 1,
                'hrg_beli' => $this->input->post('hrg_beli'),
                'nm_barang' => $this->input->post('nm_barang'), 
                'jml_beli' => $this->input->post('jml_beli'),
                'stok' => $this->input->post('stok'),
                'hrg_modal' => $this->input->post('hrg_modal'),
                'hrg_satuan' => $this->input->post('hrg_satuan'),

            );     
            $this->cart->insert($data);             
            redirect('transaksi/detailPembelian');
        }   
    }

    public function hapusCard($id){   
        $data = array('rowid' => $id,
                      'qty' =>0);            
        $this->cart->update($data); 
        redirect('transaksi/detailPembelian');
    }

    public function hapusidBarang(){
        $this->session->unset_userdata('idbarang');
        redirect('transaksi/detailPembelian');
    }


    public function simpanData(){
       $cart = $this->cart->contents();   
       foreach ($cart as $key => $value) {
           $no_pembelian = $this->session->userdata('detailid');
           $idbarang =$value['id'];
           $nm_barang = $value['nm_barang'];
           $hrg_beli = $value['hrg_beli'];
           $jml_beli =$value['jml_beli'];
           $stok =$value['stok'];
           $hrg_modal =$value['hrg_modal'];
           $hrg_satuan =$value['hrg_satuan'];        
           //rumus
           $tambahStok = $stok + $jml_beli;         
           echo $updateharga = (($hrg_beli * $jml_beli) + ($stok * $hrg_modal)) / $tambahStok;
            //end rumus

           $dataUpade = [
            'hrg_modal' => $updateharga,
            'stok' => $tambahStok
            ];
            $this->db->where('idbarang',$idbarang);
            $this->db->update('barang',$dataUpade);

           $data = [
            'no_pembelian' => $no_pembelian,
            'idbarang' => $idbarang,
            'harga_beli' => $hrg_beli,
            'jumlah' => $jumlah,
            ];
            $this->db->insert('pembelian_detail',$data); 
       };
       $this->cart->destroy(); 
       $this->session->unset_userdata('idbarang');
       $this->session->unset_userdata('detailid');
       redirect('transaksi/');
    }


    public function hapusDetailTrasaksi(){
        $this->cart->destroy(); 
        $this->session->unset_userdata('detailid');
        redirect('transaksi/');
    }

    public function allSupiller(){
        $this->session->unset_userdata('suppiler');
        redirect('transaksi');
    }

    public function alldata(){
        $this->session->unset_userdata('keyword');
        redirect('transaksi/detailPembelian');
    }

// ------------------------------------------------------------------------------------------------------------------------------------------

public function penjualan(){
    









}

}