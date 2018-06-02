<?php
namespace Ngpictures\Services\Auth;


use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookAuthService extends AuthService
{
    private $app_namespace = 'ngpictures-test';
    private $app_id = '518552818524133';
    private $app_secret = '2d3f266e8a3fa73f75fa25b519cd02b7';
    private $default_graph_version = 'v2.11';

    private function catch($e, string $msg)
    {
        if ($this->app::hasDebug()) {
            echo "<pre>";
            echo "{$msg}";
            print_r($e);
            echo "</pre>";
            exit;
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }

    /**
     * @throws FacebookSDKException
     */
    public function connect()
    {
        $this->session;
        try {
            $fb = new Facebook([
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => $this->default_graph_version
            ]);
        } catch (FacebookSDKException $e) {
            $this->catch($e, $e->getMessage());
        }

        $helper = $fb->getCanvasHelper();
        $permissions = ['email'];


        //check if the access token already exists
        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $accessToken = $_SESSION['facebook_access_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }
        } catch (FacebookResponseException $e) {
            $this->catch($e, 'Graph returned an error');
        } catch (FacebookSDKException $e) {
            $this->catch($e, 'Facebook SDK returned an error');
        }

        if (isset($accessToken)) {
            // setting the access token
            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                $oAuth2Client = $fb->getOAuth2Client();     // OAuth 2.0 client handler
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }


            // validating the access token
            try {
                $request = $fb->get('/me');
            } catch (FacebookResponseException $e) {
                if ($e->getCode() == 190) {
                    unset($_SESSION['facebook_access_token']);
                    $helper = $fb->getRedirectLoginHelper();
                    $loginUrl = $helper->getLoginUrl("https://apps.facebook.com/".$this->app_namespace."/", $permissions);
                    echo "<script>window.top.location.href='".$loginUrl."'</script>";
                    exit;
                }
            } catch (FacebookSDKException $e) {
                $this->catch($e, 'Facebook SDK returned an error');
            }


            // getting basic info about user
            try {
                $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
                $profile = $profile_request->getGraphNode()->asArray();
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                unset($_SESSION['facebook_access_token']);
                echo "<script>window.top.location.href='https://apps.facebook.com/".$this->app_namespace."/'</script>";
                exit;
            } catch (FacebookSDKException $e) {
                $this->catch($e, 'Facebook SDK returned an error');
            }

            // priting basic info about user on the screen
            print_r($profile);
            // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
        } else {
            $helper = $fb->getRedirectLoginHelper();
            $loginUrl = $helper->getLoginUrl("https://apps.facebook.com/".$this->app_namespace."/", $permissions);
            echo "<script>window.top.location.href='".$loginUrl."'</script>";
        }
    }
}