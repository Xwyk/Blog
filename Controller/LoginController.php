<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;

class LoginController extends Controller
{
    public const URL_ADMIN      =    "/admin";
    public const URL_HOME       =    "/";
    public const URL_LOGIN      =    "/login";
    public const VIEW_LOGIN     =    "login";
    
    public function display()
    {
        $redirect = $this->router->request->getGetValue('redirect');
        $email    = $this->router->request->getPostValue('email');
        $password = $this->router->request->getPostValue('password');
        // $redirect = filter_input(INPUT_GET, 'redirect');
        if ($redirect) {
            $this->setRedirection($redirect);
        }
        if ($this->session->isAuthenticated()) {
            $this->redirect($this->router->url('home_page'));
            return;
        }
        if (! $email || ! $password) {
            $formUrl=$this->router->url('login_page');
            if ($redirect) {
                $formUrl.='/?redirect='.$redirect;
            }
            $this->render($this::VIEW_LOGIN, ['formUrl'=>$formUrl]);
            return;
        }
        // $this->login();
    }

    public function login()
    {
        try {
            $this->session->login((new UserManager($this->config))->login(
                filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ));
            $redirect = filter_input(INPUT_GET, 'redirect');
            if ($redirect) {
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
