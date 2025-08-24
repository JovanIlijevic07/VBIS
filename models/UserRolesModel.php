<?php

namespace app\models;

use app\core\Model;

class UserRolesModel extends Model
{
    public int $user_id;
    public int $role_id;

    public function writeAttributes(): array
    {
        return ["user_id", "role_id"];
    }

    public function readAttributes(): array
    {
        return ["id", "user_id", "role_id"];
    }

    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return "user_roles";
    }
}