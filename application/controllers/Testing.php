<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('cart');
    }

    public function index()
    {
        $data['title'] = 'Array Push';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['datax'] = $this->db->get('user')->result_array();
        $data['tahun']= ['1990','1991','1992','1993','1994','1995','1996','1997','1998','1999','2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010','2011','2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022','2023','2024','2025','2026','2027','2028','2029','2030'];
        
        $data['barang'] = $this->db->get('barang')->result_array();
        $arraylist = array(
            array(
                    'id'      => 'Product1',
                    'qty'     => 5,
                    'price'   => 500,
                    'name'    => 'Kolak',
                    'options' => array('Size' => 'L', 'Color' => 'Red')
            ),     
        );
        
        $this->cart->insert($arraylist);



        $data['pembelian'] =[''];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('testing/index', $data);
        $this->load->view('templates/footer');
  
    }



}
