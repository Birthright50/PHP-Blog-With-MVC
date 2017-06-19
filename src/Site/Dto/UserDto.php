<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 3:56
 */
namespace Birthright\Site\Dto;
class UserDto
{

    /**
     * UserDto constructor.
     * @param array $registration_form
     */
    public function __construct(array $registration_form)
    {
        $this->setUsername($registration_form['username']);
        $this->setCaptcha($_POST['g-recaptcha-response']);
        $this->setEmail($registration_form['email']);
        $this->setPassword($registration_form['password']);
        $this->setMatchingPassword($registration_form['matchingPassword']);
    }
    private $captcha;
    private $username;
    private $email;
    private $avatar;
    private $password;
    private $matchingPassword;
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
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param mixed $captcha
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
    }
    /**
     * @return mixed
     */
    public function getMatchingPassword(){
        return $this->matchingPassword;
    }

    /**
     * @param mixed $matchingPassword
     */
    public function setMatchingPassword($matchingPassword){
        $this->matchingPassword = $matchingPassword;
    }

    /**
     * @return mixed
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username){
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email){
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAvatar(){
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password){
        $this->password = $password;
    }


}