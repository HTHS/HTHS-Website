<?php


class Google extends CI_Controller
{
    private $client;

    public function __construct()
    {
        parent::__construct();
        require_once APPPATH . 'classes/google-api-php-client/src/Google_Client.php';

        $this->client = new Google_Client();

        $this->client->setClientId($this->config->item('google_client_id'));
        $this->client->setClientSecret($this->config->item('google_client_secret'));

        $this->client->setRedirectUri(site_url('/google/login'));
        $this->client->setScopes(array('openid', 'email'));
        $this->client->setApprovalPrompt('auto');
        $this->client->setAccessType('online');

        if ($this->session->userdata('google_token')) {
            $this->client->setAccessToken($this->session->userdata('google_token'));
        }
    }

    public function index()
    {
        if ($this->session->userdata('google_token')) {
            var_dump($this->getPayload());
            echo '<a href="' . site_url('/google/logout') . '">Logout</a>';
        } else {
            echo '<a href="' . site_url('/google/login') . '">Login</a>';
        }
    }

    public function login()
    {
        if (isset($_GET['code'])) {
            $this->doAuth();
            redirect('/google');
        } else {
            $this->doLoginRedirect();
        }
    }

    public function logout()
    {
        $this->doLogout();
        redirect('/google');
    }

    /**
     * @return array Payload profile information
     */
    private function getPayload()
    {
        return $this->client->verifyIdToken()->getAttributes()['payload'];
    }

    private function doLoginRedirect()
    {
        redirect($this->client->createAuthUrl());
    }

    private function doAuth()
    {
        $this->session->set_userdata('google_token', $this->client->authenticate());
        if (!$this->isValid()) {
            $this->doLogout();
            return false;
        }
        return true;
    }

    private function doLogout()
    {
        $this->session->unset_userdata('google_token');
        $this->client->revokeToken();
    }

    /**
     * Check that the user is in the ctemc.org domain
     * @return bool true if user is valid, false if invalid
     */
    private function isValid()
    {
        $payload = $this->getPayload();
        return (isset($payload['hd']) && $payload['hd'] == 'ctemc.org');
    }
}
