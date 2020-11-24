<?php

namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Token;
use Blog\Model\User;

/**
 *
 */
class TokenManager extends Manager
{
    protected const TOKEN_VALIDITY_MINUTES = 1;
    protected const MAX_ALLOWED_TOKENS     = 2;
    public const TOKEN_EXPIRED             = 3;
    public const TOKEN_INVALID             = 2;
    public const TOKEN_VALID               = 1;
    protected const BASE_REQUEST           = 'SELECT  
                            token.user AS tokenUser,
                            token.value AS tokenValue,
                            token.generation_date AS tokenGenerationDate,
                            token.expiration_date AS tokenExpirationDate,

                            user.id AS userId, 
                            user.pseudo AS userPseudo, 
                            user.first_name AS userFirstName, 
                            user.last_name AS userLastName, 
                            user.mail_address AS userMailAddress
                            FROM token 
                            INNER JOIN user
                            ON token.user=user.id ';

    public function getByUser(User $user)
    {
        $sqlRequest = self::BASE_REQUEST.'WHERE user = :user;';
        $token      = $this->executeRequest($sqlRequest, [':user'=>$user->getId()]);
        $result     = $token->fetch();
        if (!$result) {
            throw new \Exception("aucun token enregistré", 1);
        }
        $result = $this->createFromArray($result);
        return $result;
    }

    public function getByValue(string $tokenValue)
    {
        $sqlRequest = self::BASE_REQUEST.'WHERE value = :value;';
        $token      = $this->executeRequest($sqlRequest, [':value'=>$tokenValue]);
        $result     = $token->fetch();
        if ($result) {
            $result = $this->createFromArray($result);
        }
        return $result;
    }

    public function create($tokenLength = 32, User $user)
    {
        $tokenValue      = bin2hex(openssl_random_pseudo_bytes($tokenLength));
        $tokenGeneration = new \DateTime();
        $tokenExpiration = clone $tokenGeneration;
        $tokenExpiration->modify('+ '.$this::TOKEN_VALIDITY_MINUTES.' minutes');
        $this->removeOld();
        $this->removeForUser($user);
        $this->add($this->createFromArray([
            'tokenValue'          => $tokenValue,
            'tokenGenerationDate' => $tokenGeneration,
            'tokenExpirationDate' => $tokenExpiration,
            'userId' => $user->getId(),
            'userPseudo' => $user->getPseudo(),
            'userFirstName' => $user->getFirstName(),
            'userLastName' => $user->getLastName(),
            'userMailAddress' => $user->getMailAddress()
        ]));
        return $tokenValue;
    }

    protected function add($tokenToAdd)
    {
        $request = 'INSERT INTO token (user, 
                                      value,
                                      generation_date,
                                      expiration_date)
                    VALUES (:user, 
                            :value, 
                            :generation_date, 
                            :expiration_date);';
        $result  = $this->executeRequest($request, [
            ':user'            => $tokenToAdd->getUser()->getId(),
            ':value'           => $tokenToAdd->getValue(),
            ':generation_date' => $tokenToAdd->getGenerationDate()->Format('Y-m-d H:i:s'),
            ':expiration_date' => $tokenToAdd->getExpirationDate()->Format('Y-m-d H:i:s')
        ]);
        return $result;
    }

    public function check(string $tokenToCheck, User $user)
    {
        if (strcmp($this->getByUser($user)->getValue(), $tokenToCheck) !== 0) {
            return $this::TOKEN_INVALID;
        }
        if ($this->getByUser($user)->getExpirationDate() < (new \DateTime())->format('Y-m-d H:i:s')) {
            return $this::TOKEN_EXPIRED;
        }
        return $this::TOKEN_VALID;
    }

    public function createFromArray(array $data)
    {
        return new Token([
            'user'            => (new UserManager($this->config))->createFromArray($data),
            'value'              => $data['tokenValue'],
            'generation_date' => $data['tokenGenerationDate'],
            'expiration_date' => $data['tokenExpirationDate']
        ]);
    }

    public function removeForUser(User $user)
    {
        
        $request = 'DELETE FROM token WHERE user = :user;';
        $result  = $this->executeRequest($request, [':user'=>$user->getId()]);
        return $result;
    }

    public function removeOld()
    {
        $request = 'DELETE FROM token WHERE expiration_date < :expDate;';
        $result  = $this->executeRequest($request, [':expDate'=>(new \DateTime())->format('Y-m-d H:i:s')]);
        return $result;
    }
}
