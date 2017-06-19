<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 14.06.17
 * Time: 18:45
 */
namespace Birthright\Core\Service;
use Birthright\Core\Entity\UserEntity;
use Birthright\Core\Repository\PersistenceLoginRepository;

class PersistentTokenBasedRememberMeService
{

    private $tokenRepository;
    private $tokenLength;
    private $seriesLength;
    private $domain;
    private $tokenValiditySeconds;
    private $userService;


    public function __construct()
    {
        $this->tokenRepository = new PersistenceLoginRepository();
        $this->tokenLength = TOKEN_LENGTH;
        $this->seriesLength = SERIES_LENGTH;
        $this->tokenValiditySeconds = TOKEN_VALIDITY_SECONDS;
        $this->domain = 'test.com';
        $this->userService = new UserService();
    }

    public function generateSeriesData(): string
    {
            return bin2hex(random_bytes($this->seriesLength));
    }

    public function generateTokenData(): string
    {
        return bin2hex(random_bytes($this->tokenLength));
    }

    public function processAutoLoginCookie(): void
    {
        $value = base64_decode($_COOKIE[REMEMBER_ME_COOKIE]);
        $arr = explode(':', $value);
        if (sizeof($arr) !== 2) {
            return;
        }
        $series = $arr[0];
        $token = $arr[1];
        $persistenceLogin = $this->tokenRepository->getTokenForSeries($series);
        if (is_null($persistenceLogin)) {
            return;
        }
        if ($token !== $persistenceLogin->getToken()) {
            $this->tokenRepository->removeUserTokens($persistenceLogin->getUserId());
            return;
        }
        if (strtotime($persistenceLogin->getLastUsed()) + $this->tokenValiditySeconds > time()) {
            $newToken = $this->generateTokenData();
            $this->tokenRepository->updateToken($series, $newToken);
            setcookie(REMEMBER_ME_COOKIE,
                base64_encode($series . ':' . $newToken),
                time() + $this->tokenValiditySeconds, '/', $this->domain,
                false, true);
            $user = $this->userService->findById($persistenceLogin->getUserId());
            $user->setPassword(null);
            $_SESSION[USER_SESSION] = $user;
        }
    }

    public function onLoginSuccess(UserEntity $userEntity)
    {
        $userId = $userEntity->getId();
        $series = $this->generateSeriesData();
        $token = $this->generateTokenData();
        $this->tokenRepository->createNewToken($userId, $series, $token);
        setcookie(REMEMBER_ME_COOKIE,
            base64_encode($series . ':' . $token),
            time() + $this->tokenValiditySeconds, '/', $this->domain, false, true);
    }

    public function logout(): void
    {
        if (isset($_COOKIE[REMEMBER_ME_COOKIE])) {
            $this->cancelCookie();
        }
        $this->tokenRepository->removeUserTokens($_SESSION[USER_SESSION]->getId());
    }


    private function cancelCookie(): void
    {
        setcookie(REMEMBER_ME_COOKIE,
            $_COOKIE[REMEMBER_ME_COOKIE],
            1, '/', $this->domain, false, true);
    }

}