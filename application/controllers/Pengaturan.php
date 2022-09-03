<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
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
        $this->load->model('Recovery_model', 'pengaturan');
        $this->load->dbutil();
        is_logged_in();
       
    }
    public function index(){
        $data['title'] = 'Recovery Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();   
        $data['nota_beli'] = $this->report->getNota();
        $data['pilih'] = 0;          
        $config['base_url'] = 'http://localhost/admin-graha/pengaturan';
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
        

        $config['total_rows'] =$this->db->count_all_results(); 
        $data['total_rows'] = $config['total_rows']; 
        $config['per_page'] = 12;
        
        //inisialisasi
        $this->pagination->initialize($config);     
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->pengaturan->getPembelian($config['per_page'], $data['start']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/index', $data);
        $this->load->view('templates/footer');
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