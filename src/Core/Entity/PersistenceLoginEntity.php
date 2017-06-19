<?php
/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 14.06.17
 * Time: 16:15
 */
namespace Birthright\Core\Entity;
class PersistenceLoginEntity{
    private $series;
    private $userId;
    private $token;
    private $lastUsed;

    /**
     * PersistenceLoginEntity constructor.
     * @param $series
     * @param $userId
     * @param $token
     * @param $lastUsed
     */
    public function __construct($series, $userId, $token, $lastUsed = null)
    {
        $this->series = $series;
        $this->userId = $userId;
        $this->token = $token;
        $this->lastUsed = $lastUsed;
    }

    /**
     * @return mixed
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param mixed $series
     */
    public function setSeries($series)
    {
        $this->series = $series;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getLastUsed()
    {
        return $this->lastUsed;
    }

    /**
     * @param mixed $lastUsed
     */
    public function setLastUsed($lastUsed)
    {
        $this->lastUsed = $lastUsed;
    }
}