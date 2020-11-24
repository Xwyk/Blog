<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;

class LoginController extends Controller
{
    public const VIEW_LOGIN = "login";
    
    public function display()
    {
        $redirect = $this->router->request->getGetValue('redirect');
        if ($redirect) {
            $this->setRedirection($redirect);
        }
        if ($this->session->isAuthenticated()) {
            $this->redirect($this->router->url('home_page'));
            return;
        }
        $formUrl = $this->router->url('login_request');
        if ($redirect) {
            $formUrl .= '/?redirect='.$redirect;
        }
        $this->render($this::VIEW_LOGIN, ['formUrl'=>$formUrl]);
        return;
    }

    public function login()
    {
        try {
            $redirect = $this->router->request->getGetValue('redirect');
            $email    = $this->router->request->getPostValue('email');
            $password = $this->router->request->getPostValue('password');
            if ($redirect) {
                $this->setRedirection($redirect);
            }
            $this->session->login((new UserManager($this->config))->login($email, $password));
            if ($redirect) {
                $this->setRedirection($redirect);
            }
            if ($this->session->isAdmin()) {
                $this->redirect($this->router->url('admin_page'));
                return;
            }
            $this->redirect($this->router->url('home_page'));
        } catch (\Exception $e) {
            $this->render($this::VIEW_LOGIN, ['error' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        $this->session->logout();
        $this->redirect($this->router->url('home_page'));
    }
}
