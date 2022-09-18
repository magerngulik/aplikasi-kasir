<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Barang_model', 'barang');
        $this->load->model('Supiler_model', 'suppiler');
        $this->load->model('Konsumen_model', 'konsumen');
       
    }
// ------------------------------------------------------------Barang-----------------------------------------------------------------------
    public function index()
    {
        $data['title'] = 'Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['tAssets'] = $this->barang->getSumAssets();
        $data['tStock'] = $this->barang->getSumStock();
        $config['base_url'] = 'http://localhost/admin-graha/data/index';
        if ( $this->input->post('keyword')) {
            $data['keyword']= $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        }else {
            $data['keyword']= $this->session->userdata('keyword');
        }         
        // echo $search = str_replace(' ','_',$data['keyword']);
        // $search = preg_replace('/\s+/', '', $data['keyword']);

        $array = array('idbarang' =>  $data['keyword'], 'nm_barang' =>  $data['keyword']);
        $this->db->from('barang'); 
        $this->db->or_like($array);
        // $this->db->or_having('nm_barang',  $data['keyword']);
        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 13;
        
        //inisialisasi
        $this->pagination->initialize($config);
        
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->menu->getBarang($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/index', $data);
        $this->load->view('templates/footer');
    
    }

    public function alldata(){
        $this->session->unset_userdata('keyword');
        redirect('data');
    }

    public function tambahBarang(){
        $data['title'] = 'Tambah Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->barang->allkategori();
        // $tampil = $this->barang->getLastData();
        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('hrg_modal', 'Harga Modal', 'required|trim|numeric');
        $this->form_validation->set_rules('hrg_satuan', 'Harga Satuan', 'required|trim|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim|numeric');
        $this->form_validation->set_rules('kategori', 'kategori', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/tambah_barang', $data);
            $this->load->view('templates/footer');
        } else {

            $basicformat = "9990001";
            $katpoin = $this->input->post('kategori');       
            $this->db->select_max('idbarang');       
            $this->db->from('barang a'); 
            $this->db->join('kategori b', 'a.idkategori=b.idkategori', 'left');
            $this->db->where('a.idkategori',$katpoin);
      
            $num = $this->db->get()->row_array();    
            $katnumber = (int)$katpoin;
            $hasikKategori="";     
            
             $num['idbarang'];
            // echo "   ";
            
            // echo "<br>";
            // echo "Last Charakter=";
             $bil= substr($num['idbarang'],-3);
            // echo "   ";
            // echo "<br>";
            // echo "Last Kategorie=";
            $a= substr($num['idbarang'],7,-3);
            // echo "   ";
            // echo "<br>";
            // echo "Last +1=";
            $count = (int)$bil +1;
            // echo "<br>";

            if($katnumber <10){
                $hasikKategori = "00".(string) $katnumber;
            }else
            if ($katnumber <100) {
                $hasikKategori = "0".(string) $katnumber;   
            }else
            if($katnumber >=100){
                $hasikKategori = $katnumber;
            }

            $text1 = (int)$num['idbarang'];
            // echo 
            // $count = $text1 + 1;
            $total = "";
        
            if($count <10){
                $total = "00".(string) $count;
            }else
            if ($count <100) {
                $total = "0".(string) $count;   
            }else
            if($count >=100){
                $total = $count;
            }

            // echo "   ";
            // echo "<br>";
            // echo "Basic Format=";
            // echo $basicformat;
            // echo "   ";
            // echo "<br>";
            // echo "No Kategorie=";
            // echo $hasikKategori;
            // echo "   ";
            // echo "<br>";
            // echo "No Urutan=";
            // echo $total;
            // echo "   ";
            // echo "<br>";

            echo $endpoin = $basicformat.$hasikKategori.$total;
            

            $data = [
                'idbarang' => $endpoin,
                'nm_barang' => $this->input->post('nm_barang'),
                'hrg_modal' => $this->input->post('hrg_modal'),
                'hrg_satuan' => $this->input->post('hrg_satuan'),
                'stok' => $this->input->post('stok'),
                'idkategori' => $this->input->post('kategori'),
            ];
            $this->db->insert('barang', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Barang di Tambahkan!</div>');
            redirect('data');
        }
    }


    public function hapusDataBarang($id){
        $tabelname = "barang";
        $tabelId = "idbarang";
        $this->load->model('Menu_Model','menu');
        $this->menu->deleteData($id,$tabelname,$tabelId);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil di hapus!</div>');
        redirect('data');
    }

    public function editBarang($id){
        $data['title'] = 'Edit Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['barang'] = $this->barang->getBarangById($id);
        $data['kategori'] = $this->barang->allkategori();
        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('hrg_modal', 'Harga Modal', 'required|trim|numeric');
        $this->form_validation->set_rules('hrg_satuan', 'Harga Satuan', 'required|trim|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim|numeric');
        $this->form_validation->set_rules('menu_id', 'kategori', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/editBarang', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_barang' => $this->input->post('nm_barang'),
                'hrg_modal' => $this->input->post('hrg_modal'),
                'hrg_satuan' => $this->input->post('hrg_satuan'),
                'stok' => $this->input->post('stok'),
                'idkategori' => $this->input->post('menu_id'),
            ];
            $this->db->where('idbarang',$id);
            $this->db->update('barang',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil di ubah!</div>');
            redirect('data');
        }
    }

// ------------------------------------------------------------Menu Kategori----------------------------------------------------------------
    public function kategori(){
        $data['title'] = 'Kategori';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['kategori'] = $this->barang->allkategori();

        $this->form_validation->set_rules('nm_kategori', 'Nama Kategori', 'required');

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_kategori' => $this->input->post('nm_kategori'),
            ];
            $this->db->insert('kategori', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kategori berhasil di tambahkan!</div>');
            redirect('data/kategori');
        }
    }

    public function hapusDataKategori($id){
        $tabelname = "kategori";
        $tabelId = "idkategori";
        $this->menu->deleteData($id,$tabelname,$tabelId);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil di hapus!</div>');
        redirect('data/kategori');
    }

    public function editKategori($id){

        $data['title'] = 'Kategori';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['kategori'] = $this->barang->getKategoriBy($id);

        $this->form_validation->set_rules('nm_kategori', 'Nama Kategori', 'required');

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/editKategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_kategori' => $this->input->post('nm_kategori'),
            ];
            $this->db->where('idkategori',$id);
            $this->db->update('kategori',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kategori berhasil di ganti!</div>');
            redirect('data/kategori');
        }
    }

// ------------------------------------------------------------Menu Suppiler----------------------------------------------------------------
    public function allSupiller(){
        $this->session->unset_userdata('suppiler');
        redirect('data/suppiler');
    }

    public function suppiler(){  
        $data['title'] = 'Suppiler';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $config['base_url'] = 'http://localhost/admin-graha/data/suppiler';
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
        $config['per_page'] = 13;
        
        //inisialisasi
        $this->pagination->initialize($config);     
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->suppiler->getSupplier($config['per_page'], $data['start'],$data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/supiler', $data);
        $this->load->view('templates/footer');

    }

   public function tambahSupplier(){
    $data['title'] = 'Tambah Data Suppiler';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['kategori'] = $this->barang->allkategori();
    
    // <!-- supplier idsupplier	nm_supplier	alamat	no_telp	kontak -->
    $this->form_validation->set_rules('nm_supplier', 'Nama Suppiler', 'required|trim');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    $this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required|trim|numeric');
    $this->form_validation->set_rules('kontak', 'Kontak', 'required|trim|numeric');
    if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/tambah_suppiler', $data);
        $this->load->view('templates/footer');
    } else {
        $basicformat = "PS-";            
        $num = $this->db->count_all_results('supplier', FALSE); 
        $text1 = (int)$num;
        $count = $text1 + 1;                 
        $id = $basicformat.$count;
        $data = [
            'idsupplier' => $id,
            'nm_supplier' => $this->input->post('nm_supplier'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'kontak' => $this->input->post('kontak')
        ];
        $this->db->insert('supplier', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Suppiler di Tambahkan!</div>');
        redirect('data/suppiler/');
    }
   }

    public function hapusSuppiler($id){
        $tabelname = "supplier";
        $tabelId = "idsupplier";
        $this->menu->deleteData($id,$tabelname,$tabelId);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil di hapus!</div>');
        redirect('data/suppiler');
    }

    public function editsuppiler($id){
  
    // <!-- supplier idsupplier	nm_supplier	alamat	no_telp	kontak -->
        $data['title'] = 'Kategori';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['kategori'] = $this->suppiler->getSuppilerBy($id);

        $this->form_validation->set_rules('nm_supplier', 'Nama Suppiler', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required|trim|numeric');
        $this->form_validation->set_rules('kontak', 'Kontak', 'required|trim|numeric');

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/editsuppiler', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nm_supplier' => $this->input->post('nm_supplier'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'kontak' => $this->input->post('kontak'),
            ];
            $this->db->where('idsupplier',$id);
            $this->db->update('supplier',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Suppiler berhasil di ganti!</div>');
            redirect('data/suppiler');
        }
    }

// ------------------------------------------------------------Konsumen--------------------------------------------------------------------

public function allKonsumen(){
    $this->session->unset_userdata('konsumen');
    redirect('data/konsumen');
}

    // konsumen idpelanggan	nm_konsumen	alamat no_telp
public function konsumen(){  
    $data['title'] = 'Konsumen';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $config['base_url'] = 'http://localhost/admin-graha/data/konsumen';
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
    $this->load->view('data/konsumen', $data);
    $this->load->view('templates/footer');

}

public function tambahKonsumen(){
 // konsumen idpelanggan nm_konsumen alamat no_telp
$data['title'] = 'Tambah Data Konsumen';
$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
$data['kategori'] = $this->barang->allkategori();
$this->form_validation->set_rules('nm_konsumen', 'Nama Suppiler', 'required|trim');
$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
$this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required|trim|numeric');
if ($this->form_validation->run() == false) {
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('data/tambah_konsumen', $data);
    $this->load->view('templates/footer');
} else {
    $basicformat = "PL-";            
    $num = $this->db->count_all_results('konsumen', FALSE);;  
    $text1 = (int)$num;
    $count = $text1 + 1;
    $total = "";
    
    if($count >=100){
        $total = $count;
    }else
    if ($count <100) {
        $total = "0".(string) $count;   
    }else 
    if($count <10){
        $total = "00".(string) $count;
    }

    $id = $basicformat.$total;
    $data = [   
        'idpelanggan' => $id,
        'nm_konsumen' => $this->input->post('nm_konsumen'),
        'alamat' => $this->input->post('alamat'),
        'no_telp' => $this->input->post('no_telp')
    ];
    $this->db->insert('konsumen', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Konsumen di Tambahkan!</div>');
    redirect('data/konsumen/');
}
}

public function hapusKonsumen($id){
    $tabelname = "konsumen";
    $tabelId = "idpelanggan";
    $this->menu->deleteData($id,$tabelname,$tabelId);
    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil di hapus!</div>');
    redirect('data/konsumen');
}

public function editKonsumen($id){

    // konsumen idpelanggan	nm_konsumen	alamat no_telp
    $data['title'] = 'Edit Konsumen';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['subMenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();
    $data['kategori'] = $this->konsumen->getKonsumenBy($id);

    $this->form_validation->set_rules('nm_konsumen', 'Nama Suppiler', 'required|trim');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    $this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required|trim|numeric');

    if ($this->form_validation->run() ==  false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/editkonsumen', $data);
        $this->load->view('templates/footer');
    } else {
        $data = [
            'nm_konsumen' => $this->input->post('nm_konsumen'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp')
        ];
        $this->db->where('idpelanggan',$id);
        $this->db->update('konsumen',$data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Konsumen berhasil di ganti!</div>');
        redirect('data/konsumen');
    }
}

// ------------------------------------------------------------Pegawai--------------------------------------------------------------------


    public function pegawai(){
        $data['title'] = 'Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['datauser'] = $this->db->get('user')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('data/pegawai', $data);
        $this->load->view('templates/footer');    
    }

    public function tambahPegawai(){
        $data['title'] = 'Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['datauser'] = $this->db->get('user')->result_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Username', 'required|trim|is_unique[user.email]', [
            'is_unique' => 'Username ini sudah di gunakan!','required' => 'Username tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repassword]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password Terlalu Penderk!'
            ,'required' => 'Password tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('repassword', 'Password', 'required|trim|matches[password]',['required' => 'Ulangi Password tidak boleh kosong!',
        'matches' => 'Password tidak sama!'
        ]);
        $this->form_validation->set_rules('role', 'Role', 'required|trim',['required' => 'Role Harus dipilih!']);

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/tambah_pegawai', $data);
            $this->load->view('templates/footer'); 
        } else {
                $basicformat = "PEG-";            
                $num = $this->db->count_all_results('user', FALSE);;  
                $text1 = (int)$num;
                $count = $text1 + 1;
                $total = "";        
                if($count <10){
                    $total = "00".(string) $count;
                }else  
                if ($count <100) {
                    $total = "0".(string) $count;   
                }else
                if($count >=100){
                    $total = $count;
                }        
                $id = $basicformat.$total;
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($this->input->post('name', true)),
                    'image' => 'default.jpg',
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role_id' => $this->input->post('role'),
                    'is_active' => 1,
                    'date_created' => time(),
                    'id_pegawai' => $id 
                ];
                $this->db->insert('user', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Pegawai di Tambahkan!</div>');
                redirect('data/pegawai/');
        }
        
    }


    
    public function hapusPegawai($id){
        $tabelname = "user";
        $tabelId = "id";
        $this->menu->deleteData($id,$tabelname,$tabelId);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil di hapus!</div>');
        redirect('data/pegawai');
    }

    public function editPegawai($id){

        $data['title'] = 'Edit Pegawai';
        $data['user'] = $this->db->get_where('user', ['id' => $id])->row_array();
        $data['datauser'] = $this->db->get('user')->result_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('name', 'Username', 'required|trim');
       
        $this->form_validation->set_rules('role', 'Role', 'required|trim',['required' => 'Role Harus dipilih!']);

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/editpegawai', $data);
            $this->load->view('templates/footer'); 
        } else {
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($this->input->post('name', true)),
                    'role_id' => $this->input->post('role'),               
                ];

                $this->db->where('id',$id);
                $this->db->update('user',$data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Pegawai di Tambahkan!</div>');
                redirect('data/pegawai/');
        }
        
    }
}