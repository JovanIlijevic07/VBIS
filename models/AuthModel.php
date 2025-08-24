<?php

namespace app\models;

use app\core\Model;

class AuthModel extends Model
{
    public string $email;
    public string $password;

    public function writeAttributes(): array
    {
        return ["email", "password", "active"];
    }

    public function readAttributes(): array
    {
        return ["email", "password", "active", "id"];
    }

    public function rules(): array
    {
        return [
            'password' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }

    public function tableName(): string
    {
        return "users";
    }

    public function registration()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->active = true;

        $this->create();

        $this->mapData($this->one("where email = '$this->email'"));
        $role_model = new RoleModel();

        $role_model->mapData($role_model->one("where name = 'Korisnik'"));

        $user_role_model = new UserRolesModel();

        $user_role_model->user_id = $this->id;
        $user_role_model->role_id = $role_model->id;

        $user_role_model->create();
    }

    public function login(): bool
    {
        $result = $this->one("where email = '$this->email'");

        if ($result != null)
            return password_verify($this->password, $result["password"]);

        return false;
    }

    public function sessionData(): SessionModel
    {
        $sqlString = "select u.email, r.name as 'role' from user_roles ur
                            inner join users u on ur.user_id = u.id
                            inner join roles r on ur.role_id = r.id;";

        $dbResult = $this->query($sqlString);

        $sessionModel = new SessionModel();

        while ($result = $dbResult->fetch_assoc()) {
            $sessionModel->email = $result['email'];
            $sessionModel->roles[] = $result['role'];
        }

        return $sessionModel;
    }
}