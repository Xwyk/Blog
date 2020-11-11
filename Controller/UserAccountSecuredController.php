<?php

namespace Blog\Controller;

use Blog\Exceptions\WrongPasswordException;
use Blog\Framework\SecuredController;
use Blog\Model\Manager\UserManager;

/**
 * Manages admin display on website
 */
class UserAccountSecuredController extends SecuredController
{
    public const VIEW_USERACCOUNT = "userAccount";
    public function save()
    {
        $oldPassword = $this->router->request->getPostValue('oldPassword');
        $newPassword1 = $this->router->request->getPostValue('newPassword1');
        $newPassword2 = $this->router->request->getPostValue('newPassword2');
        $connectedUser = (new UserManager($this->config))->getByMail($this->session->getAttribute('user')->getMailAddress());
        $newPseudo = $this->router->request->getPostValue('inputPseudo');
        $connectedUser->hydrate([
            'pseudo'   => $newPseudo
        ]);
        if ($oldPassword!="") {
            if (!password_verify($oldPassword, $connectedUser->getPassword())) {
                $this->display(['error' => new WrongPasswordException("Ancien mot de passe incorrect")]);
                return;
            }
            if (strcmp($newPassword1, $newPassword2) != 0) {
                $this->display(['error' => new WrongPasswordException("Les nouveaux mots de passe ne correspondent pas")]);
                return;
            }

            $connectedUser->hydrate([
                'password' => password_hash($newPassword1, PASSWORD_DEFAULT)
            ]);
        }
        (new UserManager($this->config))->update($connectedUser);
        $this->session->login($connectedUser);
        $this->display([
            'info' => 'Les modifications seront prises en compte à la prochaine connexion'
        ]);
    }

    public function display(array $data=[])
    {
        $data['user'] = $this->session->getAttribute('user');
        //var_dump($this->session->getAttribute('user')->getMailAddress());
        $this->render($this::VIEW_USERACCOUNT, $data);
        return;
    }
}
