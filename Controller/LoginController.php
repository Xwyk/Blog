<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;

class LoginController extends Controller
{
    public const URL_ADMIN      =    "/?action=admin";
    public const URL_HOME       =    "/?action=home";
    public const URL_LOGIN      =    "/?action=login";
    public const VIEW_LOGIN     =    "login";
    
    public function display()
    {
        $redirect = filter_input(INPUT_GET, 'redirect');
        if ($redirect) {
            $this->setRedirection($redirect);
        }
        if ($this->session->isAuthenticated()) {
            $this->redirect($this::URL_HOME);
            return;
        }
        if (!(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) || !(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS))) {
            $formUrl=$this::URL_LOGIN;
            if ($redirect) {
                $formUrl.='&redirect='.urlencode($redirect);
            }
            $this->render($this::VIEW_LOGIN, ['formUrl'=>$formUrl]);
            return;
        }
        $this->login();
    }

    private function login()
    {
        try {
            $this->session->login((new UserManager($this->config))->login(
                filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ));
            $redirect = filter_input(INPUT_GET, 'redirect');
            if ($redirect) {
                var_dump($redirect);
                $this->setRedirection($redirect);
            }
            if ($this->session->isAdmin()) {
                $this->redirect($this::URL_ADMIN);
                return;
            }
            $this->redirect($this::URL_HOME);
        } catch (\Exception $e) {
            $this->render($this::VIEW_LOGIN, ['error' => $e->getMessage()]);
        }
    }


    public function logout()
    {
        $this->session->logout();
        $this->redirect($this::URL_HOME);
    }
}
