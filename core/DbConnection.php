<?php

namespace app\core;

use mysqli;

class DbConnection
{
    public function connection(): mysqli
    {
        return new mysqli("localhost", "root", "root", "wbis");
    }

    public function query($queryString)
    {
        $con = $this->connection();

        return $con->query($queryString);
    }

    public function fetchList($dbResult): array
    {
        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        return $resultArray;
    }

    public function fetchOne($dbResult)
    {
        return $dbResult->fetch_assoc();
    }
}