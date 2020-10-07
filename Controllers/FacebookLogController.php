<?php

namespace Controllers;

include_once('Facebook/autoload.php');

use \Models\UserModel as UserModel;
use \DAO\UserDAO as UserDAO;

class FacebookLogController
{
    private $fb;
    private $helper;
    private $loginUrl;

    public function __construct()
    {
        include_once('Facebook/autoload.php');
        $this->fb = new \Facebook\Facebook(array(
            'app_id' => '383668786136123',
            'app_secret' => '07cde429233190afc3f433c626dbfc0e',
            'default_graph_version' => 'v3.2',
        ));

        $this->helper = $this->fb->getRedirectLoginHelper();

        $permissions = array('email'); // Optional permissions
        $this->loginUrl = $this->helper->getLoginUrl(
            'http://'.$_SERVER['HTTP_HOST'].'/personal/moviepass/FacebookLog/Login/', 
            $permissions
        );
        
        //$this->logoutUrl = $this->helper->getLogoutUrl($_SESSION['fbAccessToken'], 'http://localhost/personal/moviepass/FacebookLog/Logout/');
    }

    public function Index()
    {
        echo htmlspecialchars($this->loginUrl);
        echo '<hr>';
        echo htmlspecialchars($this->loginUrl);
        echo '<hr>';
        // HomeController::MainPage();
    }

    public function Logout ()
    {
        unset($_SESSION['fbUserId']);
        unset($_SESSION['fbUserName']);
        unset($_SESSION['fbAccessToken']);
    }

    public function Login()
    {
        try {
            $accessToken = $this->helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($this->helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $this->helper->getError() . "\n";
                echo "Error Code: " . $this->helper->getErrorCode() . "\n";
                echo "Error Reason: " . $this->helper->getErrorReason() . "\n";
                echo "Error Description: " . $this->helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                //$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                throw new \Facebook\Exceptions\FacebookSDKException();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }
        }

        //$fb->setDefaultAccessToken($accessToken);

        # These will fall back to the default access token
        $res    =   $this->fb->get('/me', $accessToken->getValue());
        $fbUser =   $res->getDecodedBody();


        $resImg     =   $this->fb->get('/me/picture?type=large&amp;redirect=false', $accessToken->getValue());
        $picture    =   $resImg->getGraphNode();


        $_SESSION['fbUserId']       =   $fbUser['id'];
        $_SESSION['fbUserName']     =   $fbUser['name'];
        $_SESSION['fbAccessToken']  =   $accessToken->getValue();

        header('Location: welcome.php');
        exit;

        $fbname = 'username';
        $fbemail = 'email';
        require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
        UserDAO::getUserByEmail('');
        //si el usuario no esta registrado
        if ('') {
            $fbname = 'username';
            $fbemail = 'email';
            require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
        } elseif ('') {
            HomeController::MainPage();
        }
    }

    public function Register(String $username, String $password, int $dni, String $birthday, String $email)
    {
        if (!LogController::ValidateSession()) {
            $time = strtotime($birthday);
            $newformat = date('Y-m-d', $time);

            $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
            $result = UserDAO::addUser($newUser);

            if ($result instanceof UserModel) {
                $_SESSION['current_user'] = UserDAO::getUserByEmail($email);
            }
        }
        HomeController::MainPage();
    }
}
