<?php

namespace Controllers;

use \Models\UserModel as UserModel;
use \DAO\UserDAOjson as UserDAO;
use Models\Exceptions\AddUserException;
use Models\PopupAlert;

class FacebookSessionController
{
    private $fb;
    private $helper;

    public function __construct()
    {
        include_once('Facebook/autoload.php');

        $this->fb = FacebookSessionController::GetFacebookObject();
        $this->helper = FacebookSessionController::GetRedirectLoginHelper($this->fb);
    }

    private function GetLoginUrl()
    {
        $permissions = array('email'); // Optional permissions
        if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
            return $this->helper->getLoginUrl(
                'http://' . $_SERVER['HTTP_HOST'] . '/personal/moviepass/FacebookSession/Login/',
                $permissions
            );
    }

    private function GetLogoutUrl(\Facebook\Authentication\AccessToken $fbAccessToken, String $url)
    {
        if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
            return  $this->helper->getLogoutUrl(
                $fbAccessToken,
                $url
            );
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

    public static function Register(String $username, String $password, int $dni, String $birthday, String $email)
    {
        try {
            if (!SessionController::ValidateSession()) {
                $time = strtotime($birthday);
                $newformat = date('Y-m-d', $time);

                $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
                $result = UserDAO::addUser($newUser);

                if ($result instanceof UserModel) {
                    SessionController::SetSession(UserDAO::getUserByEmail($email));
                }
            }
        } catch (AddUserException $adu) {
            $alert = new PopupAlert($adu->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }

    public function Index()
    {
        if (SessionController::ValidateSession()) {
            HomeController::MainPage();
            exit;
        }

        header('Location: ' . $this->GetLoginUrl());
    }

    private function Logout(\Facebook\Authentication\AccessToken $accessToken, String $url)
    {
        header('Location: ' . $this->GetLogoutUrl($accessToken, $url));
    }

    public function Login()
    {
        if (SessionController::ValidateSession()) {
            HomeController::MainPage();
            exit;
        }

        try {
            if ($this->helper instanceof \Facebook\Helpers\FacebookRedirectLoginHelper)
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
            if ($_SESSION['helper']->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $_SESSION['helper']->getError() . "\n";
                echo "Error Code: " . $_SESSION['helper']->getErrorCode() . "\n";
                echo "Error Reason: " . $_SESSION['helper']->getErrorReason() . "\n";
                echo "Error Description: " . $_SESSION['helper']->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        # These will fall back to the default access token
        $res    =   $this->fb->get("/me?fields=id, first_name, last_name, email", $accessToken->getValue());
        $fbUser =   $res->getDecodedBody();

        /*
        $resImg     =   $this->fb->get('/me/picture?type=large&amp;redirect=false', $accessToken->getValue());
        $picture    =   $resImg->getGraphNode();
        */

        // 'http://localhost/personal/moviepass/' this logout

        $usr = UserDAO::getUserByEmail($fbUser['email']);
        if ($usr instanceof UserModel) {
            SessionController::SetSession($usr);
            HomeController::MainPage();
            exit;
        } else {
            $fbname = $fbUser['first_name'] . ' ' .  $fbUser['last_name'];
            $fbemail = $fbUser['email'];
            require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
            exit;
        }
    }
}
