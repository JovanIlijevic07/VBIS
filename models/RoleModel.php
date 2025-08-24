<?php

namespace app\models;

use app\core\Model;

class RoleModel extends Model
{
    public string $name;

    public function writeAttributes(): array
    {
        return ["name"];
    }

    public function readAttributes(): array
    {
        return ["name", "id"];
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return "roles";
    }
}