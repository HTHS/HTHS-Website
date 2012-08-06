<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Login extends CI_Controller {
    
    public function index() {
        require(APPPATH . 'classes/openid.php');
        $openid = new LightOpenID($_SERVER['HTTP_HOST']);
        if (!$openid->mode) {
            // Didn't get login info from the OpenID provider yet / came from the login link
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
            header('Location: ' . $openid->authUrl());
        } else if ($openid->mode == 'cancel') {
            // The user decided to cancel logging in, so we'll redirect to the home page instead
            redirect('/');
        } else {
            // The user has logged in and the user's info is ready
            if (!$openid->validate()) {
                // Authentication failed, try logging in again
                $this->login_failure();
            } else {
                // Authentication was successful
                
                // Get user attributes:
                $user_data = $openid->getAttributes();
                
                // Check to make sure that the user is logging in using a @ctemc.org account:
                if (preg_match('/^[^@]+@ctemc\.org$/', $user_data['contact/email'])) {
                    echo "Welcome, " . " " . $user_data['namePerson/first'] . ' ' . $user_data['namePerson/last'];
                } else {
                    $this->login_failure();
                }
                
            }
        }
    }
    
    private function login_failure() {
        echo 'Login failure';
    }
    
}
