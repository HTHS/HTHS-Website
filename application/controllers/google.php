<?php


class Google extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('google_login');
    }

    public function index()
    {
        if ($this->google_login->isLoggedIn()) {
            var_dump($this->google_login->getPayload());
            echo '<a href="' . site_url('/google/logout') . '">Logout</a>';
        } else {
            echo '<a href="' . site_url('/google/login') . '">Login</a>';
        }
    }

    public function login()
    {
        if (isset($_GET['code'])) {
            $this->google_login->doAuth();
            redirect('/google');
        } else {
            redirect($this->google_login->getLoginRedirect());
        }
    }

    public function logout()
    {
        $this->google_login->doLogout();
        redirect('/google');
    }
}
