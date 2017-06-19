<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 14:11
 */
namespace Birthright\Core\Entity;
class UserEntity
{
    private $username;
    private $email;
    private $avatar;
    private $password;
    private $id;
    private $cover;

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function __construct($username, $email,$avatar,$cover, $password, $id = null)
    {
        $this->cover = $cover;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->password = $password;
    }

    public static function entityToAssoc(UserEntity $entity)
    {
        return [':username' => $entity->getUsername(),
            ':email' => $entity->getEmail(),
            ':avatar' => $entity->getAvatar(),
            ':password' => $entity->getPassword(),
            ':cover'=>$entity->getCover()];
    }

    public static function objectVars($user): array
    {
        return get_object_vars($user);
    }

    public static function assocToEntity($user): UserEntity
    {
        return new UserEntity($user['username'],
            $user['email'],
            $user['avatar'],
            $user['cover'],
            $user['password'],
            $user['id']
           );
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}