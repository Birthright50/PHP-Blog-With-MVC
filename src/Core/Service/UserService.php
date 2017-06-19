<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 23.04.17
 * Time: 4:00
 */
namespace Birthright\Core\Service;
use Birthright\Core\Entity\UserEntity;
use Birthright\Core\Repository\UserRepository;
use Birthright\Site\Dto\UserDto;
use Ramsey\Uuid\Uuid;
use ReflectionMethod;

class UserService
{
    private $userRepository;
    private $captchaService;

    public function __construct()
    {
        $this->captchaService = new CaptchaService();
        $this->userRepository = new UserRepository();
    }

    public function findByEmailOrUsername(string $email, string $username)
    {
        return $this->userRepository->findByEmailOrUsername($email, $username);
    }
    public function findById(int $userId){
        return $this->userRepository->findById($userId);
    }

    public function checkPasswords($one, $two): bool
    {
        return password_verify($one, $two);
    }

    public function checkUserDto(UserDto $userDto): array
    {
        $notices = [];
        //уничтожаем html теги если есть
        $userDto->setUsername(strip_tags($userDto->getUsername()));
        if (!strlen($userDto->getUsername())) {
            $notices['username'] = 'Заполните никнейм.';
        } elseif (!filter_var($userDto->getUsername(), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Zа-яА-Я0-9_-]{3,15}$/']])) {
            $notices['username'] = 'Никнейм должен быть от 3 до 15 символов.';
        }

        if (!strlen($userDto->getEmail())) {
            $notices['email'] = 'Заполните email.';
        } elseif (!filter_var($userDto->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $notices['email'] = 'Невалидный формат email\'a';
        }
        if ($this->findByEmailOrUsername($userDto->getEmail(), $userDto->getUsername())) {
            $notices['exists'] = 'Пользователь с данным email или никнеймом уже существует';
        }
// проверка секретного ключа
        $this->captchaService->verifyCaptcha($notices, $userDto->getCaptcha());
        if (!strlen($userDto->getPassword())) {
            $notices['password'] = 'Заполните пароль';
        } elseif (!filter_var($userDto->getPassword(), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/']])) {
            $notices['password'] = 'Пароль должен быть длиной не менее 8 символов';
        }
        if (!strlen($userDto->getMatchingPassword())) {
            $notices['matchingPassword'] = 'Заполните это поле';
        } elseif ($userDto->getMatchingPassword() !== $userDto->getPassword()) {
            $notices['matchingPassword'] = 'Подтверждение пароля не совпадает с паролем';
        }
        $this->uploadImg($_FILES['avatar'], $notices, $userDto, 'avatar');
        $this->uploadImg($_FILES['cover'], $notices, $userDto, 'cover');
        return $notices;
    }

    private function uploadImg($file, &$notices, UserDto $userDto, $type)
    {
        $targetDirectory = PUBLIC_PATH . "/resources/images/" . $type . "s/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
        if (!exif_imagetype($file['tmp_name'])) {
            $notices[$type] = "Один из файлов не является изображением";
            return;
        }
        if ($file["size"] > 50000000) {
            $notices[$type] = "У одного из файлов слишком большой размер";
            return;
        }
        $uuid4 = Uuid::uuid4();
        $uuid = $uuid4->toString();
        $destination = $targetDirectory . $uuid . '.' . $imageFileType;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $notices['avatar'] = "Произошла ошибка при загрузке";
        } else {
            $typeMethod = ucfirst($type);
            $reflectionMethod = new ReflectionMethod('Birthright\Site\Dto\UserDto', 'set' . $typeMethod);
            $reflectionMethod->invoke($userDto, "/resources/images/" . $type . "s/" . $uuid . '.' . $imageFileType);
        }
    }

    public function save(UserDto $userDto)
    {
        $userDto->setPassword(password_hash($userDto->getPassword(), PASSWORD_BCRYPT));
        $user = new UserEntity($userDto->getUsername(), $userDto->getEmail(), $userDto->getAvatar(), $userDto->getCover(),
            $userDto->getPassword());
        $this->userRepository->save($user);
    }
}