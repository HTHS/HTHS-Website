<?php

class Google_login extends CI_Model {

    private $client;

    const TABLE_NAME = 'google_users';

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

    /**
     * @return array Payload profile information
     */
    public function getPayload()
    {
        return $this->client->verifyIdToken()->getAttributes()['payload'];
    }

    public function getLoginRedirect()
    {
        return $this->client->createAuthUrl();
    }

    public function doAuth()
    {
        $this->session->set_userdata('google_token', $this->client->authenticate());

        // Check that user is valid, cancel if not
        if (!$this->isValid()) {
            self::doLogout();
            return false;
        } else if ($this->checkGid()) {
            self::finishAuth();
            return true;
        } else if ($this->checkEmail()) {
            $this->confirmNewUser();
            self::finishAuth();
            return true;
        } else {
            self::doLogout();
            return false;
        }
    }

    private function finishAuth() {
        $this->session->set_userdata('login', true);

        // Get user privileges
        $this->db->select('privilege');
        $this->db->from('google_users');
        $this->db->where('gid', self::getPayload()['sub']);
        $this->db->join('google_users_privileges', 'google_users.id = google_users_privileges.id', 'left inner');
        $query = $this->db->get();

        $results = $query->result();
        $privileges = array();
        foreach ($results as $result) {
            $privileges[] = $result->privilege;
        }

        $this->session->set_userdata('privileges', $privileges);
    }

    public function doLogout()
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
        $payload = self::getPayload();
        return (isset($payload['hd']) && $payload['hd'] == 'ctemc.org');
    }

    public function isLoggedIn()
    {
        return ($this->session->userdata('google_token') != false);
    }

    private function checkGid()
    {
        $this->db->where('gid', $this->getPayload()['sub']);
        $query = $this->db->get(self::TABLE_NAME);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkEmail($email = '')
    {
        if ($email == '') {
            $email = self::getPayload()['email'];
        }
        $this->db->where('email', $email);
        $this->db->where('gid', null);
        $query = $this->db->get(self::TABLE_NAME);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function confirmNewUser() {
        $this->db->where('email', $this->getPayload()['email']);
        $this->db->update(self::TABLE_NAME, array('gid' => $this->getPayload()['sub']));
    }

    public function queueNewUser($first_name, $last_name, $email) {
        if (self::checkEmail($email)) {
            return false;
        }
        $this->db->insert(self::TABLE_NAME, array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email));
        return true;
    }

}