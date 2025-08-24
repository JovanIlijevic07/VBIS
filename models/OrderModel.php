<?php

namespace app\models;

use app\core\Model;

class OrderModel extends Model
{

    public string $created_on;
    public string $created_by;
    public int $total_price;


    public function writeAttributes(): array
    {
        return ["created_on", "total_price", "created_by"];
    }

    public function readAttributes(): array
    {
        return ["id", "created_on", "total_price", "created_by"];
    }

    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return "orders";
    }
}