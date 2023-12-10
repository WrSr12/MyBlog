<?php

namespace MyProject\Models\Users;


use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /** @var ?string */
    protected $image = null;

    /**
     * @throws InvalidArgumentException|DbException
     */
    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->image = (require __DIR__ . '/../../../settings.php')['user']['avatar'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    /**
     * @throws DbException
     */
    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неверный пароль');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function updateNickname(array $post): void
    {
        if (empty($post['nickname'])) {
            throw new InvalidArgumentException('Новый никнейм не передан в запросе');
        }

        $newNickname = trim($post['nickname']);

        if (empty($newNickname) || mb_strlen($newNickname) > 50) {
            throw new InvalidArgumentException('Никнейм не может быть пустым и не может содержать более 50 символов');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $newNickname)) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (static::findOneByColumn('nickname', $newNickname) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        $this->nickname = $newNickname;

        $this->save();
    }

    public function updateImage(array $files)
    {
        if (empty($files['image']) || $files['image']['size'] === 0) {
            throw new InvalidArgumentException('Файл не загружен');
        }

        $image = $files['image'];

        // собираем путь до нового файла - папка uploads в текущей директории
        //имя файла - текущая дата + уникальный id + имя загружаемого изображения
        $imageName = date('d-m-Y') . '-' . uniqid() . '-' . $image['name'];
        $newFilePath = __DIR__ . '/../../../../www/uploads/' . $imageName;

        $allowedExtensions = ['jpg', 'png', 'gif'];
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $size = $image['size'] / (1024 * 1024);
        if ($imageSize = getimagesize($image['tmp_name'])) {
            $widthFile = $imageSize[0];
            $heightFile = $imageSize[1];
        } else {
            $widthFile = $heightFile = null;
        }

        $phpFileUploadErrors = [
            1 => 'Размер принятого файла превысил максимально допустимый размер',
            2 => 'Размер принятого файла превысил максимально допустимый размер',
            3 => 'Загружаемый файл был получен только частично',
            4 => 'Файл не был загружен',
            6 => 'Отсутствует временная папка',
            7 => 'Не удалось записать файл на диск',
            8 => 'Модуль PHP остановил загрузку файла',
        ];

        if ($size >= 8) {
            throw new InvalidArgumentException('Размер файла не должен превышать 8 Мб');
        }

        if (!in_array($extension, $allowedExtensions)) {
            throw new InvalidArgumentException('Загрузка файлов с таким расширением запрещена');
        }

        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException($phpFileUploadErrors[$image['error']]);
        }

        if (!$imageSize) {
            throw new InvalidArgumentException('Файл не является изображением');
        }

        if ($widthFile > 1920 || $heightFile > 1080) {
            throw new InvalidArgumentException('Размер изображения слишком велик');
        }

        if (!move_uploaded_file($image['tmp_name'], $newFilePath)) {
            throw new InvalidArgumentException('Ошибка при загрузке файла');
        }

        $this->image = 'http://phpzonemvc.loc/uploads/' . $imageName;
        $this->save();
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isConfirmed(): bool
    {
        return (bool)$this->isConfirmed;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}