<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pagination');
    }


    public function index()
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');
        
        $config['base_url'] = 'http://localhost/admin-graha/poin/index';
        $config['total_rows'] = $this->menu->countAllBarang();
        $config['per_page'] = 13;
        //untuk mengambil data terakhir dari segment
        $data['start'] = $this->uri->segment(3);
        $data['poin'] = $this->menu->getBarang($config['per_page'], $data['start']);
        
        //styling pagination
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-end">';
        $config['full_tag_close'] = ' </ul></nav>';

        $config['first_link'] = 'First';  
        $config['first_tag_open'] = '<li class="page-item">'; 
        $config['first_tag_close'] = '</li>'; 

        $config['last_link'] = 'Last';  
        $config['last_tag_open'] = '<li class="page-item">'; 
        $config['last_tag_close'] = '</li>'; 
       
        $config['next_link'] = '&raquo;'; 
        $config['next_tag_open'] = '<li class="page-item">'; 
        $config['next_tag_close'] = '</li>'; 

        $config['prev_link'] = '&laquo;';  
        $config['prev_tag_open'] = '<li class="page-item">'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="page-item active"> <a class="page-link" href="#">'; 
        $config['cur_tag_close'] = '</a></li>'; 
        $config['num_tag_open'] = '<li class="page-item">'; 
        $config['num_tag_close'] = '</li>'; 
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('poin/index', $data);
        $this->load->view('templates/footer');
    }

    public function datapoin()
    {
        $data['title'] = 'Data Siswa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');
        $data['poin'] = $this->menu->getSiswa();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('poin/index', $data);
            $this->load->view('templates/footer');
    }

    public function datapelangaran(){
        $data['title'] = 'Daftar Pelangaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');
        $data['pelangaran'] = $this->menu->getDataPelangaran();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('poin/data_pelangaran', $data);
        $this->load->view('templates/footer');
    }



}
