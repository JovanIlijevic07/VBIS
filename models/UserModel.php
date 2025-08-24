<?php

namespace app\models;

use app\core\Model;

class UserModel extends Model
{
    public string $password;
    public string $name;
    public string $email;
    public string $phone_number;

    public function writeAttributes(): array
    {
        return ["password", "name", "phone_number", "active", "email"];
    }

    public function readAttributes(): array
    {
        return ["id", "password", "name", "phone_number", "active", "email"];
    }

    public function tableName(): string
    {
        return "users";
    }

    public function rules(): array
    {
        return [
            'password' => [self::RULE_REQUIRED],
            'phone_number' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'active' => [self::RULE_BOOL],
            'name' => [self::RULE_REQUIRED]
        ];
    }
}