<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 4:15
 */
namespace Birthright\Core\Repository;
use Birthright\Core\Entity\UserEntity;
use PDO;

class UserRepository extends Repository
{
    public function save(UserEntity $user)
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("INSERT INTO users (username,email,avatar,cover, password) VALUES (:username,:email,:avatar,:cover, :password)");
        $STH->execute(UserEntity::entityToAssoc($user));
        $this->closeConnection();
    }

    public function isUserExists($email)
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare('SELECT * FROM users WHERE email=:email');
        $STH->execute([':email' => $email]);
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $exists = true;
        if (!$row) {
            $exists = false;
        }
        $this->closeConnection();
        return $exists;
    }

    public function findByEmailOrUsername($email, $username)
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare('SELECT * FROM users WHERE email=:email OR username=:username');
        $STH->execute([':email' => $email, ':username' => $username]);
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $this->closeConnection();
        return $row ? UserEntity::assocToEntity($row) : $row;
    }

    public function findById($userId)
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare('SELECT * FROM users WHERE id=:id');
        $STH->execute([':id' => $userId]);
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $this->closeConnection();
        return $row ? UserEntity::assocToEntity($row) : null;
    }
}