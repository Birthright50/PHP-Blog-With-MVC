<?php
namespace Birthright\Core\Repository;
use Birthright\Core\Entity as Entity;
use PDO;

class PersistenceLoginRepository extends Repository
{
    public function createNewToken(int $userId, string $series, string $token): void
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("INSERT INTO persistence_login (user_id, token, series, lastused) 
 VALUES (:user_id, :token, :series, now())");
        $STH->execute([':user_id' => $userId, ':series' => $series, ':token' => $token]);
        $this->closeConnection();
    }

    public function updateToken(string $series, string $token): void
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("UPDATE persistence_login SET token =:token, lastused = now() WHERE series =:series");
        $STH->execute([':series' => $series, ':token' => $token]);
        $this->closeConnection();
    }

    public function getTokenForSeries(string $series)
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("SELECT * FROM persistence_login WHERE series=:series");
        $STH->execute([':series' => $series]);
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $this->closeConnection();
        return $row ? new Entity\PersistenceLoginEntity($row['series'],
            $row['user_id'], $row['token'], $row['lastused']) : null;
    }

    public function removeUserTokens(int $userId): void
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("DELETE FROM persistence_login WHERE user_id=:user_id");
        $STH->execute([':user_id' => $userId]);
        $this->closeConnection();
    }
}