<?php

namespace DAO;

use \PDO as PDO;
use \Exception as Exception;

class FacebookDAO
{
    private $fb = null;
    private $helper = null;
    private static $instance = null;

    private function __construct()
    {
        try {
            include_once('Facebook/autoload.php');

            $this->fb = FacebookDAO::GetFacebookObject();
            $this->helper = FacebookDAO::GetRedirectLoginHelper($this->fb);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function GetInstance()
    {
        if (self::$instance == null)
            self::$instance = new FacebookDAO();

        return self::$instance;
    }

    private static function GetFacebookObject()
    {
        if (!isset($_SESSION['FacebookObject']))
            $_SESSION['FacebookObject'] = new \Facebook\Facebook(array(
                'app_id' => APP_ID,
                'app_secret' => APP_SECRET,
                'default_graph_version' => 'v3.2',
            ));

        return $_SESSION['FacebookObject'];
    }

    private static function GetRedirectLoginHelper(\Facebook\Facebook $fbobj)
    {
        if (!isset($_SESSION['RedirectLoginHelper']))
            $_SESSION['RedirectLoginHelper'] = $fbobj->getRedirectLoginHelper();

        return $_SESSION['RedirectLoginHelper'];
    }

    public function GetLoginUrl(String $url)
    {
        $permissions = array('email'); // Optional permissions
        if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
            return $this->helper->getLoginUrl(
                $url,
                $permissions
            );
    }

    public function GetLogoutUrl(\Facebook\Authentication\AccessToken $fbAccessToken, String $url)
    {
        if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
            return  $this->helper->getLogoutUrl(
                $fbAccessToken,
                $url
            );
    }

    public function GetUserData()
    {
        try {
            if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
                $accessToken = $this->helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            throw new Exception('Graph returned an error: ' . $e->getMessage(), 1);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            throw new Exception('Facebook SDK returned an error: ' . $e->getMessage(), 1);
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

        # These will fall back to the default access token
        $res    =   $this->fb->get("/me?fields=id, first_name, last_name, email", $accessToken->getValue());

        return $res->getDecodedBody();
    }
}
