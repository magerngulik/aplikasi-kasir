<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pagination');
        $this->load->library('form_validation');
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
            $no_pembeli = $basicformat.$hasikKategori;
            $data = [
                'no_pembelian' => $no_pembeli,
                'no_notabeli' => $this->input->post('no_nota'),
                'idpegawai' => $this->input->post('id_pegawai'),
                'idsupplier' => $this->input->post('idsupplier'),
                'jenis' => $this->input->post('jenis'),
                'tgl_masuk' => $this->input->post('tgl_msk'),
                'catatan' => '',
                'nm_supplier' => $this->input->post('nm_supplier')
            ];
            // $this->db->insert('pembelian',$data);
            $this->session->set_userdata($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nota berhasil buat!</div>');
            $this->session->set_userdata('detailid', $no_pembeli);
            $this->cart->destroy(); 
            redirect('transaksi/detailPembelian/');
        }
        
    }

    public function detailPembelian(){
        // getNopembelian
        $id = $this->session->userdata('detailid');
        $data['nota_pembelian'] = [
            'no_pembelian' => $this->session->userdata('no_pembelian'), 
            'no_notabeli' => $this->session->userdata('no_notabeli'), 
            'idpegawai' => $this->session->userdata('idpegawai'), 
            'idsupplier' => $this->session->userdata('idsupplier'), 
            'jenis' => $this->session->userdata('jenis'), 
            'tgl_masuk' => $this->session->userdata('tgl_masuk'), 
            'catatan' => $this->session->userdata('catatan'), 
            'nm_supplier' => $this->session->userdata('nm_supplier'), 

        ];
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
        // $this->cart->destroy(); 
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

        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required|trim',['required' =>'Nama Barang Tidak boleh kosong']);
        $this->form_validation->set_rules('hrg_modal', 'Harga Modal', 'required|trim',['required' =>'Harga Tidak boleh kosong']);
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim' ,['required' =>'Jenis harus di pilih']);
        $this->form_validation->set_rules('hrg_beli', 'Harga Beli', 'required|trim|numeric',['required' =>'Harga beli tidak boleh kosong', 'numeric' => 'Harus berisi data angka']);   
        $this->form_validation->set_rules('jml_beli', 'Jumlah Beli', 'required|trim|numeric',['required' =>'Jumlah beli tidak boleh kosong','numeric' => 'Harus berisi data angka']);   

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
       if(empty($cart)){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak Boleh Kosong</div>');
        redirect('transaksi/detailPembelian');

       };

       $datapembelian = [
        'no_pembelian' => $this->session->userdata('no_pembelian'), 
        'no_notabeli' => $this->session->userdata('no_notabeli'), 
        'idpegawai' => $this->session->userdata('idpegawai'), 
        'idsupplier' => $this->session->userdata('idsupplier'), 
        'jenis' => $this->session->userdata('jenis'), 
        'tgl_masuk' => $this->session->userdata('tgl_masuk'), 
        'catatan' => $this->session->userdata('catatan'),                 
       ];
       $this->db->insert('pembelian',$datapembelian);

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
           if ($stok < 0) {
            $stok = $stok * -1; 
            }
        
           $tambahStok = $stok + $jml_beli;         
                      
           $updateharga = (($hrg_beli * $jml_beli) + ($stok * $hrg_modal)) / $tambahStok;
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
            'jumlah' => $jml_beli,
            ];
            $this->db->insert('pembelian_detail',$data); 
       };
       $this->cart->destroy(); 
       $this->session->unset_userdata('idbarang');
       $this->session->unset_userdata('detailid');
       $this->session->unset_userdata('no_pembelian'); 
       $this->session->unset_userdata('no_notabeli'); 
       $this->session->unset_userdata('idpegawai'); 
       $this->session->unset_userdata('idsupplier'); 
       $this->session->unset_userdata('jenis'); 
       $this->session->unset_userdata('tgl_masuk'); 
       $this->session->unset_userdata('catatan');   
       $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi Pembelian Berhasil</div>');
       redirect('transaksi/');
    }


    public function hapusDetailTrasaksi(){
        $this->cart->destroy(); 
        $id = $this->session->userdata('detailid');
        $this->db->where('no_pembelian', $id);
        $this->db->delete('pembelian');
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
public function allKonsumen1(){
    $this->session->unset_userdata('konsumen');
    redirect('transaksi/penjualan');
}

public function penjualan(){
    $data['title'] = 'Penjualan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $config['base_url'] = 'http://localhost/admin-graha/transaksi/penjualan';
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
    $this->load->view('transaksi/penjualan/index', $data);
    $this->load->view('templates/footer');

}

public function inputNmKonsumen($id){
    $data['title'] = 'Input Nota Penjualan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['subMenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();
    $data['konsumen'] = $this->konsumen->getKonsumenBy($id);

    $this->form_validation->set_rules('tgl_msk', 'Tanggal Masuk', 'required|trim',['required' =>'Tanggal nota harus di pilih']);
    if ($this->form_validation->run() ==  false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaksi/penjualan/nm_suppiler', $data);
        $this->load->view('templates/footer');

    } else {     

       
        $today = date('ymd');
		echo $char = $today;
        $this->db->select_max('no_nota');
        $this->db->from('penjualan');
        $this->db->like('no_nota',$today );
        $date = $this->db->get()->row_array();   
        $getId = $date['no_nota'];
        $no = substr($getId, -4, 4);
        $no = (int) $no;
        $no += 1;
        $no_pembeli = $char . sprintf("%04s", $no);
        $data = [    
            // no_nota	tgl_nota jml_bayar idpegawai idpelanggan
            'no_nota' => $no_pembeli,
            'tgl_nota' => $this->input->post('tgl_msk'),
            'jml_bayar' => 0,
            'idpegawai' => $this->input->post('id_pegawai'),
            'idpelanggan' => $this->input->post('idpelanggan') ,
            'nm_konsumen' => $this->input->post('nm_konsumen') 
        ];
        // $this->db->insert('penjualan',$data);
        $this->session->set_userdata($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nota berhasil buat!</div>');
        $this->session->set_userdata('detailjual', $no_pembeli);
        $this->cart->destroy(); 
        redirect('transaksi/detailPenjualan/');
    }   
}

//atribut dari detail penjualan 
// alldataJual
public function alldataJual(){
    $this->session->unset_userdata('keyword');
    redirect('transaksi/detailPenjualan');
}

//batal transaksi
public function hapusDetailPenjualan(){
    $this->cart->destroy(); 
    $this->session->unset_userdata('detailjual');
    redirect('transaksi/penjualan');
}

//hapus data dan kembali ke menu utama
public function hapusNotaPenjualan(){
    $this->cart->destroy(); 
    $id = $this->session->userdata('detailjual');
    $this->db->where('no_nota', $id);
    $this->db->delete('penjualan');
    $this->session->unset_userdata('detailjual');
    redirect('transaksi/penjualan');
}

    public function detailPenjualan(){
        $id = $this->session->userdata('detailjual');
        
        // $data['nota_jual'] = $this->transaksi->getNoPenjualan($id);
        $data['nota_jual'] = [
            'no_nota' => $this->session->userdata('no_nota'),
            'tgl_nota' => $this->session->userdata('tgl_nota'),
            'jml_bayar' => $this->session->userdata('jml_bayar'),
            'idpegawai' => $this->session->userdata('idpegawai'),
            'idpelanggan' => $this->session->userdata('idpelanggan'),
            'nm_konsumen' => $this->session->userdata('nm_konsumen')
        ];

        //ini card nya
        $data['cart']= $this->cart->contents();
        $data['title'] = 'Input Detail Penjualan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['kategori'] = $this->suppiler->getSuppilerBy($id);
        $data['jenis'] = $this->suppiler->getSuppilerBy($id);
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $config['base_url'] = 'http://localhost/admin-graha/transaksi/detailPenjualan/';
        
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
        $this->load->view('transaksi/penjualan/detail_penjualan', $data);
        $this->load->view('templates/footer');
    }   

  //dari detail ke input
    public function iddatapenjualan($id){
        $this->session->set_userdata('idjualbarang', $id);
    
        redirect('transaksi/inputPenjualan');
    }

    public function inputPenjualan(){
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['idbarang'] = $this->session->userdata('idjualbarang');
      $data['ketbarang'] = $this->db->get_where('barang', ['idbarang' => $data['idbarang']])->row_array();
      $data['title'] = 'Input Jumlah Jual Barang';
      $data['menu'] = $this->db->get('user_menu')->result_array();
      $data['subMenu'] = $this->menu->getSubMenu();
      $idJual = $this->session->userdata('detailjual');
      $data['nota_jual'] = $this->transaksi->getNoPenjualan($idJual);
      $this->form_validation->set_rules('hrg_modal', 'Harga Beli', 'required|trim|numeric',['required' =>'Harga Modal harus di pilih', 'numeric' => 'Harus berisi data angka']);   
      $this->form_validation->set_rules('stok', 'Stok', 'required|trim|numeric',['required' =>'Stok harus di isi','numeric' => 'Harus berisi data angka']); 
      $this->form_validation->set_rules('hrg_satuan', 'Harga Jual', 'greater_than['.$this->input->post('hrg_modal').']|required|trim|numeric',['required' =>'Harga Jual harus di isi','numeric' => 'Harus berisi data angka', 'greater_than' => 'Tidak boleh di bawah harga modal']); 
      $this->form_validation->set_rules('jml_beli', 'Jumlah beli', 'required|trim|numeric',['required' =>'Jumlah beli harus di isi','numeric' => 'Harus berisi data angka']);   


      if ($this->form_validation->run() ==  false) {
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('templates/topbar', $data);
          $this->load->view('transaksi/penjualan/input_jual', $data);
          $this->load->view('templates/footer');
      } else {        
        // no_nota	idbarang jumlah	harga_jual laba
        $hargaModal =  $this->input->post('hrg_modal');
        $hargaJual =  $this->input->post('hrg_satuan');
        $jml = $this->input->post('jml_beli');


        $ele1 = $this->input->post('idbarang');
        $ele2 = $this->input->post('hrg_satuan');
        $laba = ($hargaJual - $hargaModal) * $jml;

        $id = $ele1.$ele2;
        $data = array(
              'id' => $id,
              'price' => 0,
              'name' => 'barang', 
              'qty' => 1,
              'no_nota' => $idJual,
              'idbarang' => $this->input->post('idbarang'), 
              'nm_barang' => $this->input->post('nm_barang'), 
              'stok' => $this->input->post('stok'), 
              'jumlah' => $this->input->post('jml_beli'),
              'harga_jual' => $this->input->post('hrg_satuan'),
              'laba' => $laba,
          );     
          $this->cart->insert($data);             
          redirect('transaksi/detailPenjualan');
      }   
    }

    public function simpanPenjualan(){
       $cart = $this->cart->contents();           
        if(empty($cart)){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak Boleh Kosong</div>');
        redirect('transaksi/detailPenjualan');
       };

       $datapenjualan = [
        'no_nota' => $this->session->userdata('no_nota'),
        'tgl_nota' => $this->session->userdata('tgl_nota'),
        'jml_bayar' => $this->session->userdata('jml_bayar'),
        'idpegawai' => $this->session->userdata('idpegawai'),
        'idpelanggan' => $this->session->userdata('idpelanggan'),
        // 'nm_konsumen' => $this->session->userdata('nm_konsumen')
       ];
        $this->db->insert('penjualan',$datapenjualan);
        
        foreach ($cart as $key => $value) {
            $no_pembelian = $this->session->userdata('detailjual');
            $idbarang =$value['idbarang'];
            $nm_barang = $value['nm_barang'];
            $stok = $value['stok'];
            $jumlah =$value['jumlah'];
            $hargaJual =$value['harga_jual'];
            $laba =$value['laba'];

            $tstok = $stok - $jumlah;
            $dataUpade = [
             'stok' => $tstok
             ];
             $this->db->where('idbarang',$idbarang);
             $this->db->update('barang',$dataUpade);
             
            $data = [
             'no_nota' => $no_pembelian,
             'idbarang' => $idbarang,
             'jumlah' => $jumlah,
             'harga_jual' => $hargaJual,
             'laba' => $laba,
             ];
             $this->db->insert('penjualan_detail',$data); 
        };
        $this->cart->destroy(); 
        $this->session->unset_userdata('idjualbarang');
        $this->session->unset_userdata('detailjual');
        $this->session->unset_userdata('no_nota');
        $this->session->unset_userdata('tgl_nota');
        $this->session->unset_userdata('jml_bayar');
        $this->session->unset_userdata('idpegawai');
        $this->session->unset_userdata('idpelanggan');
        $this->session->unset_userdata('nm_konsumen');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penjualan berhasil</div>');
        redirect('transaksi/penjualan');
    }

    public function hapusCardPenjualan($id){   
        $data = array('rowid' => $id,
                      'qty' =>0);            
        $this->cart->update($data); 
        redirect('transaksi/detailPenjualan');
    }


    public function hapusidJualBarang(){
        $this->session->unset_userdata('idjualbarang');
        redirect('transaksi/detailPenjualan');
    }
 
//  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------   
    public function cekharga(){
        $data['title'] = 'Cek Harga';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $config['base_url'] = 'http://localhost/admin-graha/transaksi/cekharga';
        if ($this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        }else {
            $data['keyword']= $this->session->userdata('keyword');
        }
        
        if ($this->input->post('pilih')) {
            $data['ketbarang'] = $this->db->get_where('barang', ['idbarang' => $this->input->post('pilih')])->row_array();
        }else {
            $dataBarang = [
                'nm_barang' => '',
                'hrg_modal' => ''
                ];
            $data['ketbarang'] = $dataBarang;
        }

        
        $array = array('idbarang' =>  $data['keyword'], 'nm_barang' =>  $data['keyword']);
        $this->db->from('barang'); 
        $this->db->or_like($array);
        // $this->db->or_having('nm_barang',  $data['keyword']);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 9;  
        //inisialisasi
        $this->pagination->initialize($config);       
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->menu->getBarang($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaksi/cekharga/index', $data);
        $this->load->view('templates/footer');

    }

    public function hitungharga($id){
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['ketbarang'] = $this->db->get_where('barang', ['idbarang' =>$id])->row_array();
        $data['title'] = 'Input Jumlah Jual Barang';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        
        if ($this->input->post('jml')) {
            $data['total'] = $this->input->post('jml') * $this->input->post('hrg_satuan');
         }else {
            $data['total']=0;
         }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaksi/cekharga/input_harga', $data);
        $this->load->view('templates/footer');
 
    }
    
    public function alldataHarga(){
        $this->session->unset_userdata('keyword');
        redirect('transaksi/cekharga');
    }

}