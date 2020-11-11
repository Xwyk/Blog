<?php

namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\User;
use Blog\Exceptions\UserNotActiveException;
use Blog\Exceptions\WrongPasswordException;
use Blog\Exceptions\UserNotFoundException;
use Blog\Exceptions\AlreadyUsedMailAddressException;

/**
 *
 */
class UserManager extends Manager
{
    /**
     *
     */
    public function getById(int $userId): User
    {
        $request = 'SELECT * FROM user 
                    WHERE id = :id ;';
        $user = $this->executeRequest($request, ['id' => $userId]);
        return new User($user->fetch());
    }

    public function getByMail(string $userMail)
    {
        $request = 'SELECT * FROM user 
                    WHERE mail_address = :mail ;';
        $requestResult = $this->executeRequest($request, [':mail' => $userMail]);
        $userResult = $requestResult->fetch();
        if ($userResult) {
            $user = new User($userResult);
        }
        return $user;
    }

    public function getByPseudo(string $userPseudo)
    {
        $request = 'SELECT * FROM user 
                    WHERE pseudo = :pseudo ;';
        $requestResult = $this->executeRequest($request, [':pseudo' => $userPseudo]);
        $userResult = $requestResult->fetch();
        if ($userResult) {
            $user = new User($userResult);
        }
        return $user;
    }

    public function login(string $usermail, string $password)
    {
        //TODO : replace by getuserbymail
        $request = 'SELECT * FROM user 
                    WHERE mail_address = :mailAddress ;';
        // $request = 'SELECT * FROM user 
        //             WHERE pseudo = :pseudo ;';
        $user = $this->executeRequest($request, [':mailAddress' => $usermail]);
        // $user = $this->executeRequest($request, [':pseudo' => $userPseudo]);
        $result=$user->fetch();
        if (!is_array($result)) {
            throw new UserNotFoundException($usermail);
            // throw new UserNotFoundException($userPseudo);
        }
        $user = new User($result);
        if (!$user->isActive()) {
            throw new UserNotActiveException($user->getMailAddress());
            // throw new UserNotActiveException($user->getPseudo());
        }
        if (!password_verify($password, $user->getPassword())) {
            throw new WrongPasswordException("Mot de passe incorrect");
        }
        return $user;
    }

    public function createFromArray(array $data)
    {
        return new User([
            'id'           => $data['userId'],
            'pseudo'       => $data['userPseudo'],
            'first_name'   => $data['userFirstName'],
            'last_name'    => $data['userLastName'],
            'mail_address' => $data['userMailAddress']
        ]);
    }

    public function add($userToAdd)
    {
        if ($this->getUserByMail($userToAdd->getMailAddress())) {
            throw new AlreadyUsedMailAddressException($userToAdd->getMailAddress());
        }
        // if ($this->getUserByPseudo($userToAdd->getPseudo())) {
        //     throw new AlreadyUsedPseudoException($userToAdd->getPseudo());
        // }
        $request = 'INSERT INTO user (first_name, 
                                      last_name,
                                      pseudo,
                                      mail_address,
                                      password)
                    VALUES (:firstname, 
                            :lastname, 
                            :pseudo, 
                            :mail, 
                            :pwd);';
        $result = $this->executeRequest($request, [
            ':firstname' =>$userToAdd->getFirstName(),
            ':lastname'  => $userToAdd->getLastName(),
            ':pseudo'    => $userToAdd->getPseudo(),
            ':mail'      => $userToAdd->getMailAddress(),
            ':pwd'       => $userToAdd->getPassword()]);
        return $result;
    }

    public function update(user $user)
    {
        $request = 'UPDATE user
                    SET first_name = :firstname,
                        last_name  = :lastname,
                        pseudo     = :pseudo,
                        password   = :pwd
                    WHERE id = :id;';
        $result = $this->executeRequest($request, [
            'firstname'  => $user->getFirstName(),
            'lastname'   => $user->getLastName(),
            'pseudo'     => $user->getPseudo(),
            'pwd'        => $user->getPassword(),
            'id'         => $user->getId()
        ]);
        return $result;
    }
}
