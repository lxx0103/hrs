<?php

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/Login_m');
    }

    public function index()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('auth/login_v');
        }
        else
        {
            $username = trim($this->input->post('username'));
            // $password = password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT);
            $password = trim($this->input->post('password'));
            $is_logged_in = $this->Login_m->do_login($username, $password);
            if($is_logged_in['status'] == 1)
            {
                $this->session->username = $is_logged_in['data']['username'];
                $this->session->user_id = $is_logged_in['data']['user_id'];
                $this->session->role_id = $is_logged_in['data']['role_id'];
                $this->session->role_name = $is_logged_in['data']['role_name'];
                $this->session->is_logged_in = 1;
                redirect('home');
            }else
            {
                $this->load->view('auth/login_v');
            }
        }
    }






}