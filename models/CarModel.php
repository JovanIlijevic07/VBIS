<?php

namespace app\models;

use app\core\Model;

class CarModel extends Model
{
    public int $id;
    public string $brand;
    public string $model;
    public int $price;
    public string $description;
    public string $image_path;

    public function writeAttributes(): array
    {
        return ["brand", "model", "price", "description", "image_path", "active"];
    }

    public function readAttributes(): array
    {
        return ["id", "brand", "model", "price", "description", "image_path", "active"];
    }

    public function rules(): array
    {
        return [
            "brand" => [self::RULE_REQUIRED],
            "model" => [self::RULE_REQUIRED],
            "price" => [self::RULE_REQUIRED, self::RULE_NUMBER],
            "description" => [self::RULE_REQUIRED],
            "image_path" => [self::RULE_REQUIRED],
            "active" => [self::RULE_BOOL]
        ];
    }

    public function tableName(): string
    {
        return "cars";
    }
}