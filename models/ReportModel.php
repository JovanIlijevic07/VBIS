<?php

namespace app\models;

use app\core\Model;

class ReportModel extends Model
{
    public string $dateFrom;
    public string $dateTo;
    public string $searchQuery = "";

    public function writeAttributes(): array
    {
        return [];
    }

    public function readAttributes(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return "";
    }

    public function getTotalPricePerMonth()
    {
        $result = $this->query("SELECT MONTHNAME(created_on) as 'month', sum(total_price) as 'total_price' FROM `orders` WHERE `created_on` BETWEEN '$this->dateFrom' AND '$this->dateTo' group by MONTHNAME(created_on);");

        echo json_encode($this->fetchList($result));
    }

    public function getTotalPricePerBrand()
    {
        $result = $this->query("SELECT brand, sum(price) as 'total_price' FROM `order_items` WHERE brand like '%$this->searchQuery%' or description like '%$this->searchQuery%' group by brand;");

        echo json_encode($this->fetchList($result));
    }
}